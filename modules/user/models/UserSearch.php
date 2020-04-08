<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\modules\user\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\modules\arise\helpers\AriseHelper;
use app\modules\arise\helpers\Helper;

/**
 * UserSearch represents the model behind the search form about User.
 */
class UserSearch extends User {

    /** @inheritdoc */
    public function scenarios() {
        return Model::scenarios();
    }

    public $centre;
    public $city;
    public $userrole;

    /** @inheritdoc */
    public function rules() {
        return [
            [['created_at'], 'integer'],
            [['username', 'email', 'registration_ip', 'centre', 'city', 'userrole'], 'safe'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'username' => \Yii::t('user', 'Username'),
            'email' => \Yii::t('user', 'Email'),
            'created_at' => \Yii::t('user', 'Registration time'),
            'registration_ip' => \Yii::t('user', 'Registration ip'),
            'centre' => \Yii::t('user', 'Centre'),
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = static::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['created_at' => $this->created_at])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['registration_ip' => $this->registration_ip]);

        return $dataProvider;
    }

    public function csearch($params, $rolestr) {

        $query = static::find();
        $query->joinWith(['roles']);
        $query->where("AuthAssignment.item_name in ($rolestr)");

        //echo '<pre>'; echo $city;die;
        if (isset($params['UserSearch'])) {
            if ($params['UserSearch']['city'] != '' && $params['UserSearch']['centre'] != '') {
                $query->joinWith(['roles', 'cities', 'centres']);
                $city = $params['UserSearch']['city'];
                $query->andWhere("city_id = $city");
                $centre = $params['UserSearch']['centre'];
                $query->orWhere("center_id = $centre");
            } else {
                if ($params['UserSearch']['centre'] != '') {
                    $query->joinWith(['roles', 'centres']);
                    $centre = $params['UserSearch']['centre'];
                    $query->where("center_id = $centre");
                }
                if ($params['UserSearch']['city'] != '') {
                    $query->joinWith(['roles', 'cities']);
                    $city = $params['UserSearch']['city'];
                    $query->where("city_id = $city");
                }
            }
        } else {
            $query->joinWith(['roles']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['created_at' => $this->created_at])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['registration_ip' => $this->registration_ip]);
        //->andFilterWhere(['arise_user_city.city_id' => $this->city]);
        //echo '<pre>';print_r($dataProvider);die;
        return $dataProvider;
    }

    public function arisesearch($params, $rolestr) {

        $query = static::find();
        $query->joinWith(['roles', 'city', 'org', 'school']);
        $query->where("AuthAssignment.item_name in ($rolestr)");
        if (isset(yii::$app->user->identity->role)) {
            $role = yii::$app->user->identity->role;
            if ($role == 'arisemanager') {
                $query->andWhere(['arise_user_organization.organization_city_combined' => ArrayHelper::getColumn(Helper::getcombined(1), 'id')]);
            } elseif ($role == 'organizationmanager') {
                $query->andWhere(['arise_user_school.combined_id' => ArrayHelper::getColumn(Helper::getcombined(1), 'id')]);
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['created_at' => $this->created_at])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['registration_ip' => $this->registration_ip]);

        return $dataProvider;
    }

}
