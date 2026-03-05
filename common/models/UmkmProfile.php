<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "umkm_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $nama_pemilik
 * @property string $nik
 * @property string $alamat_pemilik
 * @property string $nama_usaha
 * @property string $alamat_usaha
 * @property int|null $kecamatan_id
 * @property int|null $kelurahan_id
 * @property string|null $nib
 * @property string $no_whatsapp
 * @property float|null $latitude
 * @property float|null $longitude
 * @property float|null $modal_awal
 * @property float|null $aset_usaha
 * @property float|null $omzet_usaha
 * @property string|null $deskripsi_usaha
 * @property int|null $kategori_usaha_id
 * @property int $status_verifikasi
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Categories $kategoriUsaha
 * @property Products[] $products
 * @property UmkmDocuments[] $umkmDocuments
 * @property User $user
 */
class UmkmProfile extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'umkm_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kecamatan_id', 'kelurahan_id', 'nib', 'latitude', 'longitude', 'modal_awal', 'aset_usaha', 'omzet_usaha', 'deskripsi_usaha', 'kategori_usaha_id'], 'default', 'value' => null],
            [['status_verifikasi'], 'default', 'value' => 0],
            [['user_id', 'nama_pemilik', 'nama_usaha', 'no_whatsapp', 'created_at', 'updated_at'], 'required'],
            [['alamat_pemilik', 'nik', 'alamat_usaha'], 'safe'],
            [['user_id', 'kecamatan_id', 'kelurahan_id', 'kategori_usaha_id', 'status_verifikasi', 'created_at', 'updated_at'], 'integer'],
            [['alamat_pemilik', 'alamat_usaha', 'deskripsi_usaha', 'link_gmaps'], 'string'],
            [['latitude', 'longitude', 'modal_awal', 'aset_usaha', 'omzet_usaha'], 'number'],
            [['nama_pemilik', 'nama_usaha'], 'string', 'max' => 150],
            [['nik'], 'string', 'max' => 16],
            [['nib'], 'string', 'max' => 50],
            [['no_whatsapp'], 'string', 'max' => 20],
            [['nik'], 'unique'],
            [['nib'], 'unique'],
            [['kategori_usaha_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['kategori_usaha_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'nama_pemilik' => 'Nama Pemilik',
            'nik' => 'Nik',
            'alamat_pemilik' => 'Alamat Pemilik',
            'nama_usaha' => 'Nama Usaha',
            'alamat_usaha' => 'Alamat Usaha',
            'kecamatan_id' => 'Kecamatan ID',
            'kelurahan_id' => 'Kelurahan ID',
            'nib' => 'Nib',
            'no_whatsapp' => 'No Whatsapp',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'modal_awal' => 'Modal Awal',
            'aset_usaha' => 'Aset Usaha',
            'omzet_usaha' => 'Omzet Usaha',
            'deskripsi_usaha' => 'Deskripsi Usaha',
            'kategori_usaha_id' => 'Kategori Usaha ID',
            'status_verifikasi' => 'Status Verifikasi',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[KategoriUsaha]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKategoriUsaha()
    {
        return $this->hasOne(Categories::class, ['id' => 'kategori_usaha_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['umkm_profile_id' => 'id']);
    }

    /**
     * Gets query for [[UmkmDocuments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUmkmDocuments()
    {
        return $this->hasMany(UmkmDocuments::class, ['umkm_profile_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
