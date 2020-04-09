<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request_others_detail".
 *
 * @property int $id
 * @property int $request_help_id
 * @property string|null $detail
 * @property int|null $quantity
 * @property int $status
 */
class RequestOthersDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_others_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_help_id'], 'required'],
            [['request_help_id', 'quantity', 'status'], 'integer'],
            [['detail'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_help_id' => 'Request Help ID',
            'detail' => 'Detail',
            'quantity' => 'Quantity',
            'status' => 'Status',
        ];
    }
}
