<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_category".
 *
 * @property int $id
 * @property string $category_name
 * @property int $status
 */
class MasterCategory extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['category_name'], 'required'],
            [['status'], 'integer'],
            [['category_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'status' => 'Status',
        ];
    }

}
