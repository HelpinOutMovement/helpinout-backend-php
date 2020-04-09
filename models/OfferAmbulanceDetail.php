<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "offer_ambulance_detail".
 *
 * @property int $id
 * @property int $offer_help_id
 * @property int|null $quantity
 * @property int $status
 */
class OfferAmbulanceDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offer_ambulance_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['offer_help_id'], 'required'],
            [['offer_help_id', 'quantity', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'offer_help_id' => 'Request Offer ID',
            'quantity' => 'Quantity',
            'status' => 'Status',
        ];
    }
}
