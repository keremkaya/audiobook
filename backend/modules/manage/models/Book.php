<?php

namespace app\modules\manage\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property integer $book_id
 * @property string $book_name
 * @property string $book_genre
 * @property string $book_release_date
 * @property string $book_release_number
 * @property string $book_publisher
 * @property integer $voice_actor_id
 * @property integer $book_rating
 * @property integer $book_duration
 * @property integer $book_price
 * @property integer $author_id
 * @property string $book_picture
 *
 * @property Author $author
 * @property BookData[] $bookDatas
 * @property SaleHistory[] $saleHistories
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_name', 'book_genre', 'book_release_date', 'book_release_number', 'book_publisher', 'voice_actor_id', 'book_rating', 'book_duration', 'book_price', 'author_id', 'book_picture'], 'required'],
            [['book_release_date'], 'safe'],
            [['book_release_number', 'voice_actor_id', 'book_rating', 'book_duration', 'book_price', 'author_id'], 'integer'],
            [['book_picture'], 'string'],
            [['book_name', 'book_publisher'], 'string', 'max' => 255],
            [['book_genre'], 'string', 'max' => 55],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['author_id' => 'author_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'book_id' => 'Book ID',
            'book_name' => 'Book Name',
            'book_genre' => 'Book Genre',
            'book_release_date' => 'Book Release Date',
            'book_release_number' => 'Book Release Number',
            'book_publisher' => 'Book Publisher',
            'voice_actor_id' => 'Voice Actor ID',
            'book_rating' => 'Book Rating',
            'book_duration' => 'Book Duration',
            'book_price' => 'Book Price',
            'author_id' => 'Author ID',
            'book_picture' => 'Book Picture',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['author_id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookDatas()
    {
        return $this->hasMany(BookData::className(), ['book_id' => 'book_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleHistories()
    {
        return $this->hasMany(SaleHistory::className(), ['book_id' => 'book_id']);
    }
}
