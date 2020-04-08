<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_role".
 *
 * @property int $id
 * @property string $role_name
 * @property int $status
 */
class MasterRole extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['role_name'], 'required'],
            [['status'], 'integer'],
            [['role_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'status' => 'Status',
        ];
    }

}
