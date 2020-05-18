<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "upload_file".
 *
 * @property int $id
 * @property string|null $file_name
 */
class UploadFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'upload_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
        ];
    }
}
