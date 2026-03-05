<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "umkm_legalitas".
 *
 * @property int $id
 * @property int $umkm_profile_id
 * @property string $jenis_dokumen NIB, NPWP, HALAL, PIRT, BPOM, Lainnya
 * @property string $nomor_dokumen
 * @property string|null $file_path Path ke file upload PDF/Image
 * @property string|null $tanggal_terbit
 * @property string|null $tanggal_kedaluwarsa
 * @property int|null $status 0=Menunggu Validasi, 1=Valid, 2=Ditolak
 * @property string|null $catatan_admin
 * @property int $created_at
 * @property int $updated_at
 *
 * @property UmkmProfile $umkmProfile
 */
class UmkmLegalitas extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'umkm_legalitas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_path', 'tanggal_terbit', 'tanggal_kedaluwarsa', 'catatan_admin'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['umkm_profile_id', 'jenis_dokumen', 'nomor_dokumen', 'created_at', 'updated_at'], 'required'],
            [['umkm_profile_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['tanggal_terbit', 'tanggal_kedaluwarsa'], 'safe'],
            [['catatan_admin'], 'string'],
            [['jenis_dokumen', 'nomor_dokumen'], 'string', 'max' => 100],
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
            'tanggal_terbit' => 'Tanggal Terbit',
            'tanggal_kedaluwarsa' => 'Tanggal Kedaluwarsa',
            'status' => 'Status',
            'catatan_admin' => 'Catatan Admin',
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
