<?php

namespace app\modules\manage\models;

use Yii;

/**
 * This is the model class for table "sale_history".
 *
 * @property integer $book_id
 * @property integer $user_id
 * @property integer $id
 * @property string $sale_date
 * @property integer $sale_price
 *
 * @property Book $book
 * @property User $user
 */
class SaleHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sale_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_id', 'user_id', 'sale_date', 'sale_price'], 'required'],
            [['book_id', 'user_id', 'sale_price'], 'integer'],
            [['sale_date'], 'safe'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'book_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'book_id' => 'Book ID',
            'user_id' => 'User ID',
            'id' => 'ID',
            'sale_date' => 'Sale Date',
            'sale_price' => 'Sale Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['book_id' => 'book_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
