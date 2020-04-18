<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notification_firebase_detail".
 *
 * @property int $id
 * @property int $notification_id
 * @property string|null $firebase_id
 * @property string|null $firebase_message
 * @property int $created_at
 */
class NotificationFirebaseDetail extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'notification_firebase_detail';
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['notification_id'], 'required'],
            [['created_at'], 'safe'],
            [['notification_id', 'created_at'], 'integer'],
            [['firebase_id', 'firebase_message'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'notification_id' => 'Notification ID',
            'firebase_id' => 'Firebase ID',
            'firebase_message' => 'Firebase Message',
            'created_at' => 'Create At',
        ];
    }

}
