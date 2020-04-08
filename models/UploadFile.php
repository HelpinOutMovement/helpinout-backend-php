<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "upload_file".
 *
 * @property int $id
 * @property string $file_name
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class UploadFile extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'upload_file';
    }

    /**
     * {@inheritdoc}
     */
    public $lot_id;
    public function rules() {
        return [
            ['file_name', 'file', 'skipOnEmpty' => false],
            [['lot_id'], 'safe'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['file_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
