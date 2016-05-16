<?php

namespace app\modules\manage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\manage\models\Book;

/**
 * BookSearch represents the model behind the search form about `app\modules\manage\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_id', 'book_release_number', 'voice_actor_id', 'book_rating', 'book_duration', 'book_price', 'author_id'], 'integer'],
            [['book_name', 'book_genre', 'book_release_date', 'book_publisher', 'book_picture'], 'safe'],
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
        $query = Book::find();

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
            'book_id' => $this->book_id,
            'book_release_date' => $this->book_release_date,
            'book_release_number' => $this->book_release_number,
            'voice_actor_id' => $this->voice_actor_id,
            'book_rating' => $this->book_rating,
            'book_duration' => $this->book_duration,
            'book_price' => $this->book_price,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'book_name', $this->book_name])
            ->andFilterWhere(['like', 'book_genre', $this->book_genre])
            ->andFilterWhere(['like', 'book_publisher', $this->book_publisher])
            ->andFilterWhere(['like', 'book_picture', $this->book_picture]);

        return $dataProvider;
    }
}
