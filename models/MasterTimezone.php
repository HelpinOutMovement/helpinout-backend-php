<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_timezone".
 *
 * @property int $id
 * @property string $timezone
 * @property string $gmt
 * @property string $offset
 */
class MasterTimezone extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_timezone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['timezone', 'gmt', 'offset'], 'required'],
            [['gmt'], 'string'],
            [['timezone'], 'string', 'max' => 255],
            [['offset'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'timezone' => 'Timezone',
            'gmt' => 'Gmt',
            'offset' => 'Offset',
        ];
    }

}
