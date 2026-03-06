<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UmkmProfile;

/**
 * UmkmProfileSearch represents the model behind the search form of `common\models\UmkmProfile`.
 */
class UmkmProfileSearch extends UmkmProfile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status_verifikasi', 'created_at', 'updated_at'], 'integer'],
            [['nama_usaha', 'nik', 'no_whatsapp', 'alamat_usaha', 'alamat_pemilik', 'nib'], 'safe'],
            [['omzet_usaha'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UmkmProfile::find();

        // add conditions that should always apply here
        $query->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status_verifikasi' => $this->status_verifikasi,
            'omzet_usaha' => $this->omzet_usaha,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nama_usaha', $this->nama_usaha])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'no_whatsapp', $this->no_whatsapp])
            ->andFilterWhere(['like', 'alamat_usaha', $this->alamat_usaha])
            ->andFilterWhere(['like', 'alamat_pemilik', $this->alamat_pemilik])
            ->andFilterWhere(['like', 'nib', $this->nib]);

        return $dataProvider;
    }
}
