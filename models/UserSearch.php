<?php


namespace app\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use Yii;

class UserSearch extends User
{
//    /**
//     * @inheritdoc
//     */
//    public function rules()
//    {
//        $rules = parent::rules();
//        return $rules;
//    }


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
//        $query = User::find()->where('id != ' . Yii::$app->user->identity['id']);
        $id =(int)  Yii::$app->user->identity['id'];
        $query = User::find()->where("id != $id and id > 1");

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
            'role' => $this->role,
        ]);
        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}