<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request_ambulance_detail".
 *
 * @property int $id
 * @property int $request_help_id
 * @property int $quantity
 * @property int $status
 */
class RequestAmbulanceDetail extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'request_ambulance_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['request_help_id'], 'required'],
            [['request_help_id', 'quantity', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'request_help_id' => 'Request Help ID',
            'quantity' => 'Quantity',
            'status' => 'Status',
        ];
    }

}
