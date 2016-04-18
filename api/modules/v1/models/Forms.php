<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "forms".
 *
 * @property integer $id
 * @property string $name
 * @property string $date
 * @property integer $type
 * @property string $search_element
 * @property string $search_result
 * @property integer $parent
 * @property string $flow
 * @property string $use_roles
 * @property string $create_roles
 *
 * @property FormElements[] $formElements
 * @property FormRecords[] $formRecords
 */
class Forms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'date', 'type', 'search_element', 'search_result', 'parent', 'flow', 'use_roles', 'create_roles'], 'required'],
            [['date'], 'safe'],
            [['type', 'parent'], 'integer'],
            [['search_element', 'search_result', 'flow'], 'string'],
            [['name',  'use_roles', 'create_roles'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'date' => 'Date',
            'type' => 'Type',
            'search_element' => 'Search Element',
            'search_result' => 'Search Result',
            'parent' => 'Parent',
            'flow' => 'Flow',
            'use_roles' => 'Use Roles',
        	'create_roles' => 'Create Roles',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormElements()
    {
        return $this->hasMany(FormElements::className(), ['form_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormRecords()
    {
        return $this->hasMany(FormRecords::className(), ['form_id' => 'id']);
    }
}
