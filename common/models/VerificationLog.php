<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "verification_logs".
 *
 * @property int $id
 * @property string $entity_type
 * @property int $entity_id
 * @property int $admin_user_id
 * @property string $action
 * @property string|null $notes
 * @property int $created_at
 *
 * @property User $adminUser
 */
class VerificationLog extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'verification_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes'], 'default', 'value' => null],
            [['entity_type', 'entity_id', 'admin_user_id', 'action', 'created_at'], 'required'],
            [['entity_id', 'admin_user_id', 'created_at'], 'integer'],
            [['notes'], 'string'],
            [['entity_type'], 'string', 'max' => 50],
            [['action'], 'string', 'max' => 20],
            [['admin_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['admin_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_type' => 'Entity Type',
            'entity_id' => 'Entity ID',
            'admin_user_id' => 'Admin User ID',
            'action' => 'Action',
            'notes' => 'Notes',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[AdminUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdminUser()
    {
        return $this->hasOne(User::class, ['id' => 'admin_user_id']);
    }

}
