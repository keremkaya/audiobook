<?php

namespace api\modules\v1\controllers;

use Yii;
use \yii\rest\Controller;
use api\modules\v1\models\FormRecords;
use api\modules\v1\models\FormsData;
use common\models\Users;
use api\modules\v1\models\FormsElementRoles;
use yii\web\UploadedFile;
use api\modules\v1\models\FormElements;
use api\modules\v1\models\Forms;
use vendor\diginova\rbac\models\AuthAssignment;
use yii\web\UnauthorizedHttpException;

class FormdataController extends Controller {
	
	public $modelClass = 'api\modules\v1\models\FormsData';

	
	
	public function actions() {
		$actions = parent::actions ();
		
		// disable the "delete" and actions
		unset ( $actions ['delete'] );
		
		return $actions;
	}
	
	public function actionCreate()
	{
		if (!Yii::$app->user->can('api-formsdata-create'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$postParams = \Yii::$app->request->post();
		$getParams = Yii::$app->request->get();
		
		if (isset($postParams['elements'])) {
			
			$user = Users::findIdentityByAccessToken($getParams['access-token']);
			
			$allData = json_decode($postParams['elements']);

			$formDataIDs = [];
			foreach ($allData as $value) {
				$value = get_object_vars($value);
				$form_record_id = $value['form_record_id'];
				$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;
				$role = FormsElementRoles::findOne(['element_id' => $value['form_element_id'],'role' => $userRole->name]);
				
				if(!$role)
				{
					$element = FormElements::findOne($value['form_element_id']);
					$role = FormsElementRoles::findOne(['element_id' => $element->parent,'role' => $userRole->name]);
					if(!$role)
					{
						$element = FormElements::findOne($element->parent);
						$role = FormsElementRoles::findOne(['element_id' => $element->parent,'role' => $userRole->name]);
					}
				}

				if($role) // yazma yetkisi yok ise kayıt işlemi yapılmaz
				{
					$formElement = FormElements::findOne($value['form_element_id']);
					$formElementValue = json_decode($formElement->value);
					if($role->permission == 2 || isset($formElementValue->process))
					{
						
						
						$formsData = new FormsData();
						$formsData->user_id = $user->id;
						$formsData->form_record_id = $value['form_record_id'];
						$formsData->form_element_id = $value['form_element_id'];
						
						if(isset($formElementValue->process))
						{
							$processResult = $this->ProcessFunction($formElement, $value['form_record_id']);
							if(!($processResult['status'] == 1))
								return $processResult['status'];
						
							$formsData->value = $processResult['result'];
						}
						else
							$formsData->value = $value['value'];
						
							
						$formsData->date = $value['date'];
						$formsData->save();
						array_push($formDataIDs,['form_data_id' => $formsData->id,'form_element_id' => $formsData->form_element_id]);
					}
					else
					{
						return ['status' => 102];
					}
					
				}
				else 
					return ['status' => 102];
			}
			
		
			
			return ['status' => 1,'form_data_id' => $formDataIDs]; // success
			
		} else {
			return ['status' => 100]; // post fail
		}
	}

	public function actionGetElementValue(){
		
		if (!Yii::$app->user->can('api-formsdata-getelementvalue'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$postParams = Yii::$app->request->post();
		$getParams = Yii::$app->request->get();
	
		if (isset($postParams) && isset($postParams['elements'])) {
				
			$jsonArray = $postParams['elements'];
			$data = get_object_vars(json_decode($jsonArray));
				
			$formRecordID = $data['form_record_id'];
			$elements = $data['form_elements_id'];
			$user = Users::findIdentityByAccessToken($getParams['access-token']);
			
			if (!$user) {
				return ['status' => 102]; // error böyle bir kullanıcı yok
			}
				
			$result = [];
				
			foreach ($elements as  $value) {
				$formElement = FormElements::findOne($value);
				$formElementValue = json_decode($formElement->value);
				$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;
				$role = FormsElementRoles::findOne(['element_id' => $value,'role' => $userRole->name]);
				
				if(!$role)
				{

					$role = FormsElementRoles::findOne(['element_id' => $formElement->parent,'role' => $userRole->name]);
					if(!$role)
					{
						$element = FormElements::findOne($formElement->parent);
						$role = FormsElementRoles::findOne(['element_id' => $element->parent,'role' => $userRole->name]);
					}
				}
				
				if($role) // okuma yetkisi olmayan elementler dahil edilmez
				{
					if($role->permission == 1 || $role->permission == 2 || $role->permission == 3 )
					{
						$formsData = FormsData::findOne(['form_record_id' => $formRecordID, 'form_element_id' => $value]);
							
						if (!$formsData) {
							array_push($result, [
							'id' => 0,
							'value' => "",
							'form_element_id' => $value
							]);
						}
						else
						{
							if(isset($formElementValue->process))
							{
								$processResult = $this->ProcessFunction($formElement, $formRecordID);
								if($processResult['status'] == 1)
								{
									$formsData->value = $processResult['result'];
									$formsData->save();
								}
									
								array_push($result, [
								'id' => $formsData->id,
								'value' => $formsData->value ,
								'form_element_id' => $formsData->form_element_id
								]);
							}
							else 
							{
								array_push($result, [
								'id' => $formsData->id,
								'value' => $formsData->value,
								'form_element_id' => $formsData->form_element_id
								]);
							}
							
						}
						
					}
					else
					{
						return ['status' => 103]; // yetkisi bulunmama
					}
					
				}
					
			}
				
			return $result;

		} else {
			return ['status' => 100]; // post fail
		}
	
	}
	
	public function actionUpdateElementValue()
	{
		
		if (!Yii::$app->user->can('api-formsdata-update'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$postParams = Yii::$app->request->post();
		$getParams = Yii::$app->request->get();
		$user = Users::findIdentityByAccessToken($getParams['access-token']);
		if (isset($postParams) && isset($postParams['elements'])) {
		
			$jsonArray = $postParams['elements'];
			$data = json_decode($jsonArray);
			
			foreach ($data as  $value) {
				$formsData = FormsData::findOne($value->id);
				$formElement = $formsData->formElement;
				$formElementValue = json_decode($formElement->value);
				$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;
				$role = FormsElementRoles::findOne(['element_id' => $formsData->form_element_id,'role' => $userRole->name]);
				
				if(!$role)
				{
					$element = FormElements::findOne($formsData->formElement->parent);
					$role = FormsElementRoles::findOne(['element_id' => $element->parent,'role' => $userRole->name]);
					if(!$role)
					{
						$element = FormElements::findOne($element->parent);
						$role = FormsElementRoles::findOne(['element_id' => $element->parent,'role' => $userRole->name]);
					}
				}
				
				if($role) // kaydetme yetkisi yok ise kayıt işlemi ypaılmaz
				{
					if($role->permission == 2 || isset($formElementValue->process))
					{
						
						
						$form_record_id = $formsData->formRecord->id;
						if (!$formsData) {
							return ['status' => 101];  // error böyle bir form yok
						}
						if(isset($formElementValue->process))
						{
							$processResult = $this->ProcessFunction($formElement, $formRecordID);
							if(!($processResult['status'] == 1))
								return ['status' => 105];
							
							$formsData->value = $processResult['result'];
						}
						else 
							$formsData->value = $value->value;
						
						$formsData->date = $value->date;
						
						if(!$formsData->save())
						{
							return ['status' => 102];
						}
					}
					else
					{
						return ['status' => 103];
					}
				}
				
			}
			
			$form_record = FormRecords::findOne($form_record_id);
			if(empty($form_record->flow_history))
			{
				$flow_history = [];
				array_push($flow_history, ['date' => $form_record->date,'user_id' => $user->id]);
			}
			else
			{
				$flow_history = json_decode($form_record->flow_history);
				array_push($flow_history, ['date' => $form_record->date,'user_id' => $user->id]);
			}
			
			$form_record->flow_history = json_encode($flow_history);
			
			if(!$form_record->save())
			{
				return ['status' => 104]; // flow history kaydı oluşturulamadı
			}
		
			return ['status' => 1];
		
		
		} else {
			return ['status' => 100]; // post fail
		}
	}
	
	public function actionFileUpload()
	{
		if (!Yii::$app->user->can('api-formsdata-uploadfile'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$postParams = yii::$app->request->post();
		$getParams = yii::$app->request->get();
		$user = Users::findIdentityByAccessToken($getParams['access-token']);
		
		if(!(isset($postParams['form_record_id']) && isset($postParams['form_element_id'])))
			return ['status' => 100];
		
		$formElement = FormElements::findOne($postParams['form_element_id']);
		$userRole = AuthAssignment::findOne(['user_id' => $user->id]);
		$roles = FormsElementRoles::findOne(['role' => $userRole->item_name,'permission' => 2,'element_id' => $formElement->id]);
		$formRecordId = $postParams['form_record_id'];
		
		$image = UploadedFile::getInstanceByName('images');
		$sound = UploadedFile::getInstanceByName('sounds');
		$video = UploadedFile::getInstanceByName('videos');
		
		if(!(isset($image) || isset($sound) || isset($video)))
			return ['status' => 100];
		$dir = Yii::getAlias('@data').'/forms_data/'.$formRecordId;
		
		if(isset($image) && ($formElement->type == 12))
		{
			if(!$roles)
				return ['status' => 103];
			
			if(!is_dir($dir)) // bu yoldaki dosyalar bulunmaktamı diye kontrol yok ise o dosyaları oluşturma
			{
				mkdir($dir, 0777,true);
			}
				
			$image->saveAs($dir.'/images.zip'); // zip dosyasını taşıma
			$zip = new \ZipArchive();
			$res = $zip->open($dir.'/images.zip'); // zip dosyasını açma
			if ($res === TRUE) {
				
				if(!is_dir($dir."/images")) // images klasörü varmı diye kontrol yoksa oluşturma
					mkdir($dir."/images", 0777,true);
				$i=0;
				$imagesArray = [];
				while (1)
				{

					$fileName = $zip->getNameIndex($i);
					$fileInfo = explode('.', $fileName);
					if(!empty($fileName))
					{
						if($fileInfo[1] == "jpg")
						{
							array_push($imagesArray, $fileName);
						}
					}
					else 
						break;
					$i++;
				}
				
				if(!($zip->extractTo($dir.'/images',$imagesArray)))// dosyadakileri boşaltma
					return ['status' => 102];
				$zip->close();
				unlink($dir.'/images.zip');
			} else {
				return ['status' => 101]; //zip dosyası açılamadı
			}
		
		}
		
		if(isset($sound) && ($formElement->type == 14))
		{
			
			if(!is_dir($dir)) // bu yoldaki dosyalar bulunmaktamı diye kontrol yok ise o dosyaları oluşturma
			{
				mkdir($dir, 0777,true);
			}
			
			if(!$roles)
				return ['status' => 103];
			
			$sound->saveAs($dir.'/sounds.zip'); // zip dosyasını taşıma
			$zip = new \ZipArchive();
			$res = $zip->open($dir.'/sounds.zip'); // zip dosyasını açma
			if ($res === TRUE) {
				if(!is_dir($dir."/sounds")) // images klasörü varmı diye kontrol yoksa oluşturma
					mkdir($dir."/sounds", 0777,true);
				$i=0;
				$soundsArray = [];
				while (1)
				{

					$fileName = $zip->getNameIndex($i);
					$fileInfo = explode('.', $fileName);
					if(!empty($fileName))
					{
						if($fileInfo[1] == "mp3")
						{
							array_push($soundsArray, $fileName);
						}
					}
					else 
						break;
					$i++;
				}
				
				if(!($zip->extractTo($dir.'/sounds',$soundsArray)))// dosyadakileri boşaltma
					return ['status' => 102];
				$zip->close();
				unlink($dir.'/sounds.zip');
			} else {
				return ['status' => 101]; //zip dosyası açılamadı
			}
		}
		
		if(isset($video) && ($formElement->type == 13))
		{
			
			if(!is_dir($dir)) // bu yoldaki dosyalar bulunmaktamı diye kontrol yok ise o dosyaları oluşturma
			{
				mkdir($dir, 0777,true);
			}
			
			if(!$roles)
				return ['status' => 103];
			
			$video->saveAs($dir.'/videos.zip'); // zip dosyasını taşıma
			$zip = new \ZipArchive();
			$res = $zip->open($dir.'/videos.zip'); // zip dosyasını açma
			if ($res === TRUE) {
				if(!is_dir($dir."/videos")) // images klasörü varmı diye kontrol yoksa oluşturma
					mkdir($dir."/videos", 0777,true);
				$i=0;
				$videosArray = [];
				while (1)
				{

					$fileName = $zip->getNameIndex($i);
					$fileInfo = explode('.', $fileName);
					if(!empty($fileName))
					{
						if($fileInfo[1] == "mp4")
						{
							array_push($videosArray, $fileName);
						}
					}
					else 
						break;
					$i++;
				}
				
				if(!($zip->extractTo($dir.'/videos',$videosArray)))// dosyadakileri boşaltma
					return ['status' => 102];
				$zip->close();
				unlink($dir.'/videos.zip');
			} else {
				return ['status' => 101]; //zip dosyası açılamadı
			}
		}
		
		return ['status' => 1];
		
	}
	
	public function actionFileDownload()
	{
		
		if (!Yii::$app->user->can('api-formsdata-downloadfile'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$postParams = Yii::$app->request->post();
		$getParams = Yii::$app->request->get();
		$user = Users::findIdentityByAccessToken($getParams['access-token']);
		
		if(!isset($getParams['fileName']))
			return ['status' => 100];
		
		$formData = FormsData::find()->filterWhere(['like','value',$getParams['fileName']])->one();
		$formElement = $formData->formElement;
		
		$formRecordID = $formData->form_record_id;
		
		if($formData->formElement->type == 12)
			$dir = Yii::getAlias('@data').'/forms_data/'.$formRecordID."/images/";
	   	else if($formData->formElement->type == 14)
	   		$dir = Yii::getAlias('@data').'/forms_data/'.$formRecordID."/sounds/";
	   	else if($formData->formElement->type == 13)
	   		$dir = Yii::getAlias('@data').'/forms_data/'.$formRecordID."/videos/";
	   	$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;
	   	$role = FormsElementRoles::findOne(['element_id' => $formData->form_element_id,'role' => $userRole->item_name]);

	   	if($role) //  yetkisi yok ise indirme işlemi ypaılmaz
	   	{
	   		yii::$app->response->sendFile($dir.$getParams['fileName']);
	   	}
	   	else 
	   	{
	   		return ['status' => 101];
	   	}

	}
	
	public function ProcessFunction($formElement,$formRecordID)
	{
		$elementProcess = json_decode($formElement->value)->process;
		$avilableProcess = '';
		
		for($i=0;$i<strlen($elementProcess);$i++)
		{
			if($this->isAvailableChar($elementProcess[$i]))
			{
				$avilableProcess = $avilableProcess.$elementProcess[$i];
			}
			else
			{
				return ['status' => 200]; // hatali process oluşturulmuş
			}
		}
		
		for($i=0;$i<strlen($avilableProcess);$i++)
		{
			if($avilableProcess[$i] == 'F')
			{
					$element_id = '';
					for ($j=$i+1;$j<strlen($avilableProcess);$j++)
					{
						if($this->isAvailableChar($avilableProcess[$j],true))
						{
							$element_id = $element_id.$avilableProcess[$j];
						}
						else
							break;
					}
					
					$FirstElementId = $element_id;
					break;
			}
		}
		
		$usedElement = FormElements::findOne($FirstElementId);	
		if($usedElement->type == 10)
		{
			$formatArray = explode("-",json_decode($formElement->value)->format);
			$format = "";
			foreach ($formatArray as $row)
			{
				$format = $format."-%".$row;
			}
			$format = trim($format,"-");
				
			$dates = [];
			for($i=0;$i<strlen($avilableProcess);$i++)
			{
			if($avilableProcess[$i] == 'F')
			{
			$element_id = '';
			for ($j=$i+1;$j<strlen($avilableProcess);$j++)
			{
			if($this->isAvailableChar($avilableProcess[$j],true))
			{
			$element_id = $element_id.$avilableProcess[$j];
			}
			else
				break;
			}
		
			$formData = FormsData::findOne(['form_record_id' => $formRecordID,'form_element_id' => $element_id]);
					if(!$formData)
							{
						return ['status' => 201];
			}
				
				
			array_push($dates, $formData->value);
			}
			}
			if(count($dates) == 1)
			{
				$diff_date = date_diff(new \DateTime(), new \DateTime($dates[0]));
		}
		else
					{
					$diff_date = date_diff(new \DateTime($dates[0]), new \DateTime($dates[1]));
		}
			
			
		return ['status' => 1,'result' => strval($diff_date->format($format))];
			
					}
				
		else
		{
			for($i=0;$i<strlen($avilableProcess);$i++)
			{
				if($avilableProcess[$i] == 'F')
				{
					$element_id = '';
					for ($j=$i+1;$j<strlen($avilableProcess);$j++)
					{
						if($this->isAvailableChar($avilableProcess[$j],true))
						{
							$element_id = $element_id.$avilableProcess[$j];
						}
						else
							break;
					}
				
					$formData = FormsData::findOne(['form_record_id' => $formRecordID,'form_element_id' => $element_id]);
					
					if(!$formData)
					{
								return ['status' => 201];
					}
					$avilableProcess = str_replace('F'.$element_id, intval(trim($formData->value)), $avilableProcess);
			
				}
					
			}//process teki element id ler yerine onlarla alakalı veriler yerleştirildi
			
			eval('$result ='.$avilableProcess.';');// process çalıştırıldı
			
			return ['status' => 1,'result' => strval($result)];
		}
		
		return ['status' => 0];
		
		
	}
	
	public function isAvailableChar($char,$onlyNumber = false)
	{
		$specialCharArray = ['(',')','+','-','*','/','.','F'];
		$numberArray = ['1','2','3','4','5','6','7','8','9','0'];
		$availableCharArray = array_merge($specialCharArray,$numberArray);
		if($onlyNumber)
		{
			foreach ($numberArray as $row)
			{
				if($row == $char)
				{
					return true;
				}
			}
			
			return false;
		}
		else 
		{
			foreach ($availableCharArray as $row)
			{
				if($row == $char)
				{
					return ['status' => 1,'char' => $row];
				}
			}
			
			return false;
		}
		
		
	}
	
	
	public function actionTest()
	{
		/*$now     = new \DateTime();
		$created = new \DateTime("2015-09-10 18:12:19");
		$diff    = date_diff($now, $created);
		$days    = $diff->format('%d');
		$hours   = $diff->format('%h');
		$mins    = $diff->format('%i');
		$weeks   = $diff->format('%s');
		$mounts  = $diff->format('%m');
		$years   = $diff->format('%y');
		
		echo "\ndays =".$days;
		echo "\nhours =".$hours;
		echo "\nmins =".$mins;
		echo "\nseconds =".$weeks;
		echo "\nmounts =".$mounts;
		echo "\nyears =".$years;
		exit;*/
		$form_element = FormElements::findOne(125);
		$form_record = FormRecords::findOne(1);
		print_r($this->ProcessFunction($form_element,$form_record->id));
		exit;
	}
}