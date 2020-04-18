<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "offer_medicine_detail".
 *
 * @property int $id
 * @property int $offer_help_id
 * @property string|null $detail
 * @property int|null $quantity
 * @property int $status
 */
class OfferMedicineDetail extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'offer_medicine_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['offer_help_id'], 'required'],
            [['offer_help_id', 'quantity', 'status'], 'integer'],
            [['detail'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'offer_help_id' => 'Request Offer ID',
            'detail' => 'Detail',
            'quantity' => 'Quantity',
            'status' => 'Status',
        ];
    }

}
