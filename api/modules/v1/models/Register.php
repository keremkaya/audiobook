<?php
namespace api\modules\v1\models;

use common\models\Users;
use yii\web\UploadedFile;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class Register extends Model
{
    public $username;
    public $email;
    public $password;
    public $firstname;
    public $lastname;  
    public $access_token; 
    public $department_id;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
        	['email', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'This username has already been taken.'],
            ['email', 'email'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        		
        	['access_token', 'required'],
        	['access_token', 'string', 'min' => 6],
        		
        	['department_id', 'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
		if($this->validate()){
            $user = new Users();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if(isset($this->firstname))
            	$user->firstname = $this->firstname;
            if(isset($this->lastname))
            	$user->lastname = $this->lastname;
            $user->access_token = $this->access_token;
            $user->save();
            
            return $user;
    	}
    }

    /*public static function setTempPassword($userId, $tempPassword)
    {
    	$user = Users::findIdentity($userId);
    	$user->setPassword($tempPassword);
    	$user->password_reset_token = $tempPassword;
    	$user->reset_password = 1;
    	if ($user->save()) {
    		return true;
    	} else {
    		return false;
    	}
    }
    
    public function updatePassword($userId, $newPassword){
    	$user = Users::findIdentity($userId);
    	$user->setPassword($newPassword);
    	if ($user->save()) {
    		return true;
    	} else {
    		return false;
    	}
    }
    
    public function updateUsername($userId, $newUsername){
    	$user = Users::findIdentity($userId);
    	$user->username = $newUsername;
    	if ($user->save()) {
    		return true;
    	} else {
    		return false;
    	}
    }
    
    public function setResetPassword($userId, $val){
    	$user = Users::findIdentity($userId);
    	$user->reset_password = $val;
    	if ($user->save()) {
    		return true;
    	} else {
    		return false;
    	}
    }*/


}
