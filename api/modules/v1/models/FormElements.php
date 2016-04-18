<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "form_elements".
 *
 * @property integer $id
 * @property integer $parent
 * @property string $value
 * @property integer $type
 * @property string $key
 * @property integer $order
 * @property integer $required
 * @property integer $form_id
 *
 * @property Forms $form
 * @property FormsData[] $formsDatas
 * @property FormsElementRoles[] $formsElementRoles
 */
class FormElements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'form_elements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'value', 'type', 'key', 'order', 'form_id'], 'required'],
            [['parent', 'type', 'order', 'required', 'form_id'], 'integer'],
            [['value'], 'string'],
            [['key'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => 'Parent',
            'value' => 'Value',
            'type' => 'Type',
            'key' => 'Key',
            'order' => 'Order',
            'required' => 'Required',
            'form_id' => 'Form ID',
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
        return $this->hasMany(FormsData::className(), ['form_element_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormsElementRoles()
    {
        return $this->hasMany(FormsElementRoles::className(), ['element_id' => 'id']);
    }
}
