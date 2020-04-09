<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request_people_detail".
 *
 * @property int $id
 * @property int $request_help_id
 * @property int $volunters_required
 * @property string|null $volunters_detail
 * @property int|null $volunters_quantity
 * @property int $technical_personal_required
 * @property string|null $technical_personal_detail
 * @property int|null $technical_personal_quantity
 * @property int $status
 */
class RequestPeopleDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_people_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_help_id'], 'required'],
            [['request_help_id', 'volunters_required', 'volunters_quantity', 'technical_personal_required', 'technical_personal_quantity', 'status'], 'integer'],
            [['volunters_detail', 'technical_personal_detail'], 'string', 'max' => 256],
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
            'volunters_required' => 'Volunters Required',
            'volunters_detail' => 'Volunters Detail',
            'volunters_quantity' => 'Volunters Quantity',
            'technical_personal_required' => 'Technical Personal Required',
            'technical_personal_detail' => 'Technical Personal Detail',
            'technical_personal_quantity' => 'Technical Personal Quanity',
            'status' => 'Status',
        ];
    }
}
