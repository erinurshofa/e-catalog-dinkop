<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int $umkm_profile_id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property float $price
 * @property int $stock
 * @property string|null $unit
 * @property int $is_featured
 * @property int $status
 * @property int $view_count
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Categories $category
 * @property ProductImages[] $productImages
 * @property UmkmProfile $umkmProfile
 */
class Products extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['view_count'], 'default', 'value' => 0],
            [['unit'], 'default', 'value' => 'Pcs'],
            [['umkm_profile_id', 'category_id', 'name', 'slug', 'price', 'created_at', 'updated_at'], 'required'],
            [['umkm_profile_id', 'category_id', 'stock', 'is_featured', 'status', 'view_count', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 200],
            [['slug'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 50],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'price' => 'Price',
            'stock' => 'Stock',
            'unit' => 'Unit',
            'is_featured' => 'Is Featured',
            'status' => 'Status',
            'view_count' => 'View Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImages::class, ['product_id' => 'id']);
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
