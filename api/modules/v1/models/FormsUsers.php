<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "forms_users".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $mission
 * @property integer $status
 * @property integer $form_record_id
 *
 * @property FormRecords $formRecord
 * @property Users $user
 */
class FormsUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forms_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'mission', 'status', 'form_record_id'], 'required'],
            [['user_id', 'status', 'form_record_id'], 'integer'],
            [['mission'], 'string', 'max' => 125]
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
            'mission' => 'Mission',
            'status' => 'Status',
            'form_record_id' => 'Form Record ID',
        ];
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
