<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "form_records".
 *
 * @property integer $id
 * @property string $date
 * @property integer $form_id
 * @property integer $parents
 * @property integer $assign
 * @property string $flow_history
 *
 * @property Forms $form
 * @property FormsData[] $formsDatas
 * @property FormsUsers[] $formsUsers
 */
class FormRecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_records';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'form_id', 'parents', 'assign'], 'required'],
            [['date'], 'safe'],
            [['form_id', 'parents'], 'integer'],
            [['flow_history', 'assign'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'form_id' => 'Form ID',
            'parents' => 'Parents',
            'assign' => 'Assign',
            'flow_history' => 'Flow History',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Forms::className(), ['id' => 'form_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormsDatas()
    {
        return $this->hasMany(FormsData::className(), ['form_record_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormsUsers()
    {
        return $this->hasMany(FormsUsers::className(), ['form_record_id' => 'id']);
    }
}
