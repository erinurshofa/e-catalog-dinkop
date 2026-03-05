<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_images".
 *
 * @property int $id
 * @property int $product_id
 * @property string $image_path
 * @property string|null $image_path_thumb
 * @property int $is_primary
 * @property int $created_at
 *
 * @property Products $product
 */
class ProductImage extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_path_thumb'], 'default', 'value' => null],
            [['is_primary'], 'default', 'value' => 0],
            [['product_id', 'image_path', 'created_at'], 'required'],
            [['product_id', 'is_primary', 'created_at'], 'integer'],
            [['image_path', 'image_path_thumb'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'image_path' => 'Image Path',
            'image_path_thumb' => 'Image Path Thumb',
            'is_primary' => 'Is Primary',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

}
