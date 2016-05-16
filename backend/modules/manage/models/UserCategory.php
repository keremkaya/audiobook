<?php

namespace app\modules\manage\models;

use Yii;

/**
 * This is the model class for table "user_category".
 *
 * @property integer $user_id
 * @property integer $user_category1
 * @property integer $user_category2
 * @property integer $user_category3
 *
 * @property User $user
 */
class UserCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_category1', 'user_category2', 'user_category3'], 'required'],
            [['user_id', 'user_category1', 'user_category2', 'user_category3'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_category1' => 'User Category1',
            'user_category2' => 'User Category2',
            'user_category3' => 'User Category3',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
