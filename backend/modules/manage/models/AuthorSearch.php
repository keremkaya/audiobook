<?php

namespace app\modules\manage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * AuthorSearch represents the model behind the search form about `app\modules\author\models\Author`.
 */
class AuthorSearch extends Author
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id'], 'integer'],
            [['author_name', 'author_info_details', 'author_picture'], 'safe'],
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
        $query = Author::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'author_name', $this->author_name])
            ->andFilterWhere(['like', 'author_info_details', $this->author_info_details])
            ->andFilterWhere(['like', 'author_picture', $this->author_picture]);

        return $dataProvider;
    }
}
