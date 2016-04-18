<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "forms_element_roles".
 *
 * @property integer $id
 * @property integer $element_id
 * @property integer $permission
 * @property integer $role
 *
 * @property FormElements $element
 */
class FormsElementRoles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forms_element_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['element_id', 'permission', 'role'], 'required'],
            [['element_id', 'permission', 'role'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'element_id' => 'Element ID',
            'permission' => 'Permission',
            'role' => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElement()
    {
        return $this->hasOne(FormElements::className(), ['id' => 'element_id']);
    }
}
