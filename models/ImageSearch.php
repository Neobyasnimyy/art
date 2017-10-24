<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Image;

/**
 * ImageSearch represents the model behind the search form about `app\models\images`.
 */
class ImageSearch extends Image
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_category'], 'integer'],
            [['image_path'], 'safe'],
            ['name_for_slider', 'trim'],
            ['name_for_slider', 'string', 'max' => 255],
            [['slider_up','slider_down'],'integer'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Image::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ],
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]

        ]);

        $query->with('category');
        if(isset($params['id_category']) and $params['id_category']===0){
            $params['id_category']='';
        }
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'slider_up' => $this->slider_up,
            'slider_down' => $this->slider_down,
            'id_category' => $this->id_category,
        ]);


        $query->andFilterWhere(['like', 'image_path', $this->image_path])
            ->andFilterWhere(['like', 'name_for_slider', $this->name_for_slider]);

        return $dataProvider;
    }
}
