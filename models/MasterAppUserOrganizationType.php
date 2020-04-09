<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_app_user_organization_type".
 *
 * @property int $id
 * @property string $org_type
 * @property int $display_order
 * @property int $status
 */
class MasterAppUserOrganizationType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_app_user_organization_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['org_type', 'display_order'], 'required'],
            [['display_order', 'status'], 'integer'],
            [['org_type'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'org_type' => 'Org Type',
            'display_order' => 'Display Order',
            'status' => 'Status',
        ];
    }
}
