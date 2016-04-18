<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "forms_data".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $form_record_id
 * @property integer $form_element_id
 * @property string $value
 * @property string $date
 *
 * @property FormElements $formElement
 * @property FormRecords $formRecord
 * @property Users $user
 */
class FormsData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forms_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'form_record_id', 'form_element_id', 'value', 'date'], 'required'],
            [['user_id', 'form_record_id', 'form_element_id'], 'integer'],
            [['date'], 'safe'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'form_record_id' => 'Form Record ID',
            'form_element_id' => 'Form Element ID',
            'value' => 'Value',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormElement()
    {
        return $this->hasOne(FormElements::className(), ['id' => 'form_element_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormRecord()
    {
        return $this->hasOne(FormRecords::className(), ['id' => 'form_record_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
