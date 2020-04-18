<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "helpinout_rate_report".
 *
 * @property int $id
 * @property int $helpinout_mapping_id
 * @property int $rating_taken_for 1=requester, 2=offerer
 * @property int $offer_app_user_id
 * @property int $offer_help_id
 * @property int $request_app_user_id
 * @property int $request_help_id
 * @property float|null $rating
 * @property int|null $recommend_other
 * @property string|null $comments
 * @property int $created_at
 */
class HelpinoutRateReport extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'helpinout_rate_report';
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
            [['helpinout_mapping_id', 'rating_taken_for', 'offer_app_user_id', 'offer_help_id', 'request_app_user_id', 'request_help_id'], 'required'],
            [['created_at'], 'safe'],
            [['helpinout_mapping_id', 'rating_taken_for', 'offer_app_user_id', 'offer_help_id', 'request_app_user_id', 'request_help_id', 'recommend_other', 'created_at'], 'integer'],
            [['rating'], 'number'],
            [['comments'], 'string', 'max' => 512],
            [['helpinout_mapping_id', 'rating_taken_for'], 'unique', 'targetAttribute' => ['helpinout_mapping_id', 'rating_taken_for']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'helpinout_mapping_id' => 'Helpinout Mapping ID',
            'rating_taken_for' => 'Rating Taken For',
            'offer_app_user_id' => 'Offerer App User ID',
            'offer_help_id' => 'Offer Help ID',
            'request_app_user_id' => 'Requester App User ID',
            'request_help_id' => 'Request Help ID',
            'rating' => 'Rating',
            'recommend_other' => 'Recommend Other',
            'comments' => 'Comments',
            'created_at' => 'Created At',
        ];
    }

    public function getDetail() {
        $return = array();
        $return['rating'] = $this->rating;
        $return['recommend_other'] = $this->recommend_other;
        $return['comments'] = $this->comments;

        return $return;
    }

    public function getHelpinoutmappingdetail() {
        return $this->hasOne(HelpinoutMapping::className(), ['id' => 'helpinout_mapping_id']);
    }

}
