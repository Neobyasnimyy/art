<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Music;

/**
 * MusicSearch represents the model behind the search form about `app\models\Music`.
 */
class MusicSearch extends Music
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id'], 'integer'],
            [['name','file_name'],'trim'],
            [['name','file_name'], 'string', 'max' => 255, 'tooShort' => 'Уменьшите количество символов'],
            [['name','file_name'],'validateName'],
        ];
    }

    // наша созданная валидация, она будет работать на сервере уже
    public function validateName($attribute)
    {
        if (preg_match('/[^(\w) | (\x7F-\xFF) | (\s)]/', $this->$attribute)) {
            $this->addError($attribute, 'Имя может содержать только буквенные символы, знаки подчеркивания, пробелы, скобки.');
        }
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
        $query = Music::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ],
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
        ]);
        $query->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
