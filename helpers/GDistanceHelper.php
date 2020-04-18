<?php

/**
 * @version 1.0
 * @author Rasmus Schultz <http://blog.mindplay.dk/>
 * @license LGPL3 <http://www.gnu.org/licenses/lgpl-3.0.txt>
 */

/**
 * Helper-class to build SQL queries that calculate the geographical distance
 * from a point (in miles) - can be used with models that have latitude/longitude
 * coordinates to filter by (and/or compute) the distance from a point.
 *
 * The recommended approach, is to add one or more scope methods to your models,
 * so that the exact behavior is built into the model and easy to reuse - here
 * is an example/template scope method, using all of the key features:
 *
 *     public function near($lat, $long, $dist = 10)
 *     {
 *         $helper = new GDistanceHelper('t.geo_lat', 't.geo_long');
 *
 *         $c = $this->getDbCriteria();
 *
 *         // select all columns from the root table:
 *         $c->mergeWith(array('select' => 't.*'));
 *
 *         // optimize the query by first filtering results by bounds:
 *         $c->mergeWith($helper->getBoundsCriteria($lat, $long, $dist));
 *
 *         // filter the results further, by exact max. distance:
 *         $c->mergeWith($helper->getMaxRadiusCriteria($lat, $long, $dist));
 *
 *         // compute the radius (as a column) and bind to $distance:
 *         $c->mergeWith($helper->getRadiusCriteria($lat, $long, $dist));
 *
 *         // order results by distance:
 *         $c->mergeWith(array('order' => $helper->alias));
 *
 *         return $this;
 *     }
 *
 */
class GDistanceHelper
{
    /** @var string latitude column name/expression */
    public $lat_expr;

    /** @var string longitude column name/expression */
    public $long_expr;

    /** @var string default/base alias */
    public $alias;

    /**
     * @param string $lat_col  latitude column name/expression
     * @param string $long_col longitude column name/expression
     * @param string $alias    alias to use (by default; can be overridden in methods)
     */
    public function __construct($lat_col, $long_col, $alias = 'distance')
    {
        $this->lat_expr = $lat_col;
        $this->long_expr = $long_col;
        $this->alias = $alias;
    }

    /**
     * Compute min/max latitude and longitude ranges for a
     * circle with the given radius, at the given coordinates.
     *
     * @param $lat
     * @param $long
     * @param $distance
     * @param &$lat_min
     * @param &$lat_max
     * @param &$long_min
     * @param &$long_max
     */
    public static function getBounds(
        $lat,
        $long,
        $distance,
        // return values:
        &$lat_min,
        &$lat_max,
        &$long_min,
        &$long_max
    ) {
        $long_min = $long - $distance / abs(cos(deg2rad($lat)) * 69);
        $long_max = $long + $distance / abs(cos(deg2rad($lat)) * 69);

        $lat_min = $lat - ($distance / 69);
        $lat_max = $lat + ($distance / 69);
    }

    /**
     * Create an SQL expression to compute the distance from
     * a given latitude and longitude.
     *
     * The origin (the center from which to calculate the distance) must
     * be given as a pair of latitude/longitude placeholder names, which
     * should be bound to actual values in your query.
     *
     * The destination latitude/longitude columns to use in the expression,
     * must be given as a pair of column names/expressions.
     *
     * @param string $orig_lat  origin latitude placeholder name
     * @param string $orig_long orgin longitude placeholder name
     * @param string $dest_lat  destination latitude column name/expression
     * @param string $dest_long destination longitude column name/expression
     *
     * @return string
     */
    public static function getExpression($orig_lat, $orig_long, $dest_lat, $dest_long)
    {
        return "3956 * 2 * ASIN("
        . "SQRT("
        . "POWER(SIN((:{$orig_lat} - ABS({$dest_lat})) * PI() / 2 / 180), 2)"
        . " + COS(:{$orig_lat} * PI() / 180) * COS(ABS({$dest_lat}) * PI() / 180)"
        . " * POWER(SIN((:{$orig_long} - {$dest_long}) * PI() / 2 / 180), 2)))";
    }

    /**
     * Compute the distance between two pair of geographical coordinates.
     *
     * This is an alternative to {@see getRadiusCriteria()} which can be used to
     * compute the distance at the DBMS level - you may prefer to compute the
     * distance on demand using this method instead, for example, if you do not
     * wish to introduce a transient property to your model.
     *
     * @see getRadiusCriteria()
     *
     * @param float $orig_lat  latitude of point of origin
     * @param float $orig_long longitude of point of origin
     * @param float $dest_lat  latitude of destination point
     * @param float $dest_long longitude of destination point
     *
     * @return float distance (in miles)
     */
    public static function getDistance($orig_lat, $orig_long, $dest_lat, $dest_long)
    {
        return 3956 * 2 * asin(
            sqrt(
                pow(sin(($orig_lat - abs($dest_lat)) * M_PI_2 / 180), 2)
                + cos($orig_lat * M_PI / 180) * cos(abs($dest_lat) * M_PI / 180)
                * pow(sin(($orig_long - $dest_long) * M_PI_2 / 180), 2)
            )
        );
    }

    /**
     * Build criteria matching records with coordinates falling within
     * the boundary of a rectangle at the given coordinates.
     *
     * @param float       $lat      center latitude of bounding rectangle
     * @param float       $long     center longitude of bounding rectangle
     * @param float       $distance distance to edge of bounding rectangle (in miles)
     * @param string|null $alias    alias to use in criteria conditions
     *
     * @return CDbCriteria
     */
    public function getBoundsCriteria($lat, $long, $distance, $alias = null)
    {
        if ($alias === null) {
            $alias = $this->alias;
        }

        self::getBounds(
            $lat,
            $long,
            $distance,
            // return values:
            $lat_min,
            $lat_max,
            $long_min,
            $long_max
        );

        return new CDbCriteria(
            array(
                'condition' => "{$this->lat_expr} BETWEEN :{$alias}_lat_min AND :{$alias}_lat_max"
                    . " AND {$this->long_expr} BETWEEN :{$alias}_long_min AND :{$alias}_long_max",
                'params'    => array(
                    "{$alias}_lat_min"  => $lat_min,
                    "{$alias}_lat_max"  => $lat_max,
                    "{$alias}_long_min" => $long_min,
                    "{$alias}_long_max" => $long_max,
                )
            )
        );
    }

    /**
     * Build criteria to select the computed radius from the given coordinates.
     *
     * Note that you will need to add a public property to your model, to hold the
     * value that comes back from the database - the property name must match the
     * alias used in this criteria, so that the framework can bind the value.
     *
     * Also note that {@see CDbCriteria::$select} defaults to "*", but that
     * {@see CDbCriteria::mergeWith()} will discard the "*" select clause by default,
     * which means that no colums will be selected, which is likely not what you want -
     * to make sure that all of the columns from the root table are selected, add e.g.:
     *
     *     $criteria->mergeWith(array('select' => 't.*'));
     *
     * Alternatively, the static {@see getDistance()} method can be used to compute the
     * distance on demand, after executing the database query - the DBMS can generally
     * provide higher accuracy (more decimals) than PHP, but you may or may not be
     * comfortable introducing transient properties to persistent models.
     *
     * @see getDistance()
     *
     * @param float       $lat
     * @param float       $long
     * @param float       $distance
     * @param string|null $alias
     *
     * @return CDbCriteria
     */
    public function getRadiusCriteria($lat, $long, $distance, $alias = null)
    {
        if ($alias === null) {
            $alias = $this->alias;
        }

        $orig_lat = "{$alias}_lat";
        $orig_long = "{$alias}_long";

        $expr = self::getExpression(
            $orig_lat,
            $orig_long,
            $this->lat_expr,
            $this->long_expr
        );

        return new CDbCriteria(
            array(
                'select' => "{$expr} AS {$alias}",
                'params' => array(
                    $orig_lat  => $lat,
                    $orig_long => $long,
                )
            )
        );
    }

    /**
     * Build criteria matching records with coordinates falling within
     * the bounds of a circle with the given minimum radius, at the
     * given coordinates.
     *
     * @param float       $lat
     * @param float       $long
     * @param float       $distance
     * @param string|null $alias
     *
     * @return CDbCriteria
     */
    public function getMaxRadiusCriteria($lat, $long, $distance, $alias = null)
    {
        if ($alias === null) {
            $alias = $this->alias;
        }

        $orig_lat = "{$alias}_lat";
        $orig_long = "{$alias}_long";
        $distance_alias = "{$alias}_max";

        $expr = self::getExpression(
            $orig_lat,
            $orig_long,
            $this->lat_expr,
            $this->long_expr
        );

        return new CDbCriteria(
            array(
                'condition' => "{$expr} <= :{$distance_alias}",
                'params'    => array(
                    $orig_lat       => $lat,
                    $orig_long      => $long,
                    $distance_alias => $distance,
                )
            )
        );
    }
}