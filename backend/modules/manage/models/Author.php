<?php

namespace app\modules\manage\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "author".
 *
 * @property integer $author_id
 * @property string $author_name
 * @property string $author_info_details
 * @property string $author_picture
 *
 * @property Book[] $books
 * 
 */


class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $imagefile;
	
    public static function tableName()
    {
        return 'author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_name', 'author_info_details'], 'required'],
            [['author_info_details', 'author_picture'], 'string'],
            [['author_name'], 'string', 'max' => 55],
        	[['imagefile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
        /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'author_id' => 'Author ID',
            'author_name' => 'Author Name',
            'author_info_details' => 'Author Info Details',
            'author_picture' => 'Author Picture',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['author_id' => 'author_id']);
    }
    
    public function upload()
    {
    	if ($this->validate()) {
    		$datafolderpath = Yii::getAlias ( '@data' );
    		$imagename = Yii::$app->security->generateRandomString(10).".".$this->imagefile->extension;
    		$imagepath = $datafolderpath."/".$imagename;
    		
    		$this->imagefile->saveAs($imagepath,false);
    		$this->author_picture = "data/".$imagename;
    		return true;
    	} else {
    		return false;
    	}
    }
    
    
}
