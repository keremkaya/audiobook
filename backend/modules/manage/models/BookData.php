<?php

namespace app\modules\manage\models;

use Yii;

/**
 * This is the model class for table "book_data".
 *
 * @property integer $book_id
 * @property string $book_data
 *
 * @property Book $book
 */
class BookData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_id', 'book_data'], 'required'],
            [['book_id'], 'integer'],
            [['book_data'], 'string'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'book_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'book_id' => 'Book ID',
            'book_data' => 'Book Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['book_id' => 'book_id']);
    }
}
