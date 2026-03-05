<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "umkm_documents".
 *
 * @property int $id
 * @property int $umkm_profile_id
 * @property string $jenis_dokumen
 * @property string|null $nomor_dokumen
 * @property string $file_path
 * @property int $created_at
 * @property int $updated_at
 *
 * @property UmkmProfile $umkmProfile
 */
class UmkmDocument extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'umkm_documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor_dokumen'], 'default', 'value' => null],
            [['umkm_profile_id', 'jenis_dokumen', 'file_path', 'created_at', 'updated_at'], 'required'],
            [['umkm_profile_id', 'created_at', 'updated_at'], 'integer'],
            [['jenis_dokumen'], 'string', 'max' => 50],
            [['nomor_dokumen'], 'string', 'max' => 100],
            [['file_path'], 'string', 'max' => 255],
            [['umkm_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UmkmProfile::class, 'targetAttribute' => ['umkm_profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'umkm_profile_id' => 'Umkm Profile ID',
            'jenis_dokumen' => 'Jenis Dokumen',
            'nomor_dokumen' => 'Nomor Dokumen',
            'file_path' => 'File Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[UmkmProfile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUmkmProfile()
    {
        return $this->hasOne(UmkmProfile::class, ['id' => 'umkm_profile_id']);
    }

}
