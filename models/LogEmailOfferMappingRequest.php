<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "log_email_offer_mapping_request".
 *
 * @property int $id
 * @property int $app_user_id
 * @property string $email_address
 * @property string $datetime
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 */
class LogEmailOfferMappingRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_email_offer_mapping_request';
    }
    
    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_user_id', 'email_address', 'datetime'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['app_user_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['datetime'], 'safe'],
            [['email_address'], 'string', 'max' => 256],
            [['email_address'], 'email'],
            [['status'], 'default', 'value' => '1'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_user_id' => 'App User ID',
            'email_address' => 'Email Address',
            'datetime' => 'Datetime',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
     public function getApp_user() {
        return $this->hasOne(\app\models\AppUser::className(), ['id' => 'app_user_id']);
    }
}
