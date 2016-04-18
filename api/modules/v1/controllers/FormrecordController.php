<?php

namespace api\modules\v1\controllers;

use Yii;
use \yii\rest\Controller;
use api\modules\v1\models\FormRecords;
use api\modules\v1\models\FormsData;
use api\modules\v1\models\Forms;
use yii\web\User;
use common\models\Users;
use api\modules\v1\models\FormElements;
use vendor\diginova\rbac\models\AuthAssignment;
use yii\web\UnauthorizedHttpException;

class FormrecordController extends Controller {
	
	public $modelClass = 'api\modules\v1\models\FormRecords';
	public $existRole = false;
	
	
	public function actions() {
		$actions = parent::actions ();
		
		// disable the "delete" and actions
		unset ( $actions ['delete'] );
		
		return $actions;
	}
	
	public function actionCreate()
	{
		
		if (!Yii::$app->user->can('api-formrecord-create'))
			throw new UnauthorizedHttpException('Authentication failed.');

		$postParams = \Yii::$app->request->post();
		$getParams = yii::$app->request->get();
		$user = Users::findIdentityByAccessToken($getParams['access-token']);
		
		if (isset($postParams['date']) && isset($postParams['form_id'])) {
			$form = Forms::findOne($postParams['form_id']);
			$form_roles = json_decode($form->create_roles);
			$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;
			if(!in_array($userRole->name, $form_roles))
				return ['status' => 102];// form oluşturmaya yetkisi yoktur
			
			$model = new FormRecords();
			$form_flow = json_decode($form->flow);
			
			$model->assign = $userRole->name;
			$model->parents = 0;
			$model->date = $postParams['date'];
			$model->form_id = $postParams['form_id'];

			if ($model->save()){
				return ['status' => 1, 'form_record_id' => $model->id];
			} else {
				return ['status' => 101]; // insert fail
			}
			
		} else {
			return ['status' => 100]; // post fail
		}
	}
	
	public function actionChildFormCreate()
	{
		
		if (!Yii::$app->user->can('api-formrecord-childrecordcreate'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$postParams = yii::$app->request->post();
		$getParams = yii::$app->request->get();
		$user = Users::findIdentityByAccessToken($getParams['access-token']);
		
		if(isset($postParams['child_form_records']))
		{
			$form_records = json_decode($postParams['child_form_records']);
			$result_data = [];
			$i=0;
			foreach ($form_records as $row)
			{
				
				$form = Forms::findOne($row->child_form_id);
				$form_roles = json_decode($form->create_roles);
				$form_flow = json_decode($form->flow);
				$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;
				if(!in_array($userRole->name, $form_roles))
				{
					return ['status' => 102];
				}
				
				$model = new FormRecords();
				$model->assign = isset($row->assign) ? $row->assign : $userRole->name;
				$model->parents = $row->parent_record_id;
				$model->date =  $row->date;
				$model->form_id = $row->child_form_id;
				
				if ($model->save()){
					$result_data[$i] = ['form_record_id' => $model->id,'form_id' => $row->child_form_id];
					$i++;
				} else {
					return ['status' => 101]; // insert fail
				}
			}
			
			return ['status' => 1 ,'form_records' => $result_data ];
		}
		
		else {
			return ['status' => 100]; // post fail
		}
		
	}
	
	public function actionGetFormRecords(){
		
		
		if (!Yii::$app->user->can('api-formrecord-getformrecords'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$postParams = Yii::$app->request->post();
		
		
		if(isset($postParams['search_json']))
		{
			$json_data = json_decode($postParams['search_json']);
			
			
			$count_element = count($json_data)-1;
			
			$formData = FormsData::find();
			
			foreach ($json_data as $row)
			{
				$formData = $formData->orWhere(['form_element_id' => $row->form_element_id]);
				$formData = $formData->andWhere(['like','value',$row->value]);
			}
		
			$formData = $formData->groupBy('form_record_id');
			$formData = $formData->having('Count(form_record_id)>'.$count_element);
			$formData = $formData->orderBy(['form_record_id' => SORT_ASC]);
			$formData = $formData->all();

			if(!$formData)
			{
				return ['status' => 101];
			}
			
			$formRecordsID = [];
			foreach ($formData as $value) {
				array_push($formRecordsID, $value->form_record_id);
			}
			$data =[];
			foreach ($formRecordsID as $id)
			{
				$formRecord = FormRecords::findOne($id);
				
				$formRecordSelectedElement = json_decode($formRecord->form->search_result);
				
				$childFormRecords = FormRecords::findAll(['parents' => $id]);
				
				
				
				
				$formDataArray = [];
				foreach ($formRecordSelectedElement as $element)
				{
						$formRecordsDatas = FormsData::findOne(['form_record_id' => $formRecord->id,'form_element_id' => $element]);
						
						if(!$formRecordsDatas)
						{
							$form_element_value = json_decode(FormElements::findOne($element)->value);
							array_push($formDataArray,['form_element_id' => $element,'value' => 'Bilinmiyor','label' => $form_element_value->label]);
						}
						else 
						{
							$form_element_value = json_decode(FormElements::findOne($element)->value);
							array_push($formDataArray,['form_element_id' => $formRecordsDatas->form_element_id,'value' => $formRecordsDatas->value,'label' => $form_element_value->label]);
						}
				}
				$childFormArray = [];
				foreach ($childFormRecords as $childRecord)
				{
					$childRecordSelectedElement = json_decode($childRecord->form->search_result);
					$childFormDataArray = [];
					foreach ($childRecordSelectedElement as $element)
					{
						$formRecordsDatas = FormsData::findOne(['form_record_id' => $formRecord->id,'form_element_id' => $element]);
							
						if(!$formRecordsDatas)
						{
							$form_element_value = json_decode(FormElements::findOne($element)->value);
							array_push($childFormDataArray,['form_element_id' => $element,'value' => 'Bilinmiyor','label' => $form_element_value->label]);
						}
						else
						{
							$form_element_value = json_decode(FormElements::findOne($element)->value);
							array_push($childFormDataArray,['form_element_id' => $formRecordsDatas->form_element_id,'value' => $formRecordsDatas->value,'label' => $form_element_value->label]);
						}
					}
					
					array_push($childFormArray, [
					'id' => $childRecord->id,
					'date' => $childRecord->date,
					'form_id' => $childRecord->form_id,
					'assign' => $childRecord->assign,
					'parents' => $childRecord->parents,
					'form_data' => $childFormDataArray]);
				}
				array_push($data, [
				'id' => $formRecord->id,
				'date' => $formRecord->date,
				'form_id' => $formRecord->form_id,
				'assign' => $formRecord->assign,
				'parents' => $formRecord->parents,
				'form_data' => $formDataArray,
				'child_formrecords' => $childFormArray]);
			}

			if (!$data) {
				return ['status' => 102];
			}
			
			return $data;
		}
		else 
		{
			return ['status' => 100];
		}
	}
	
	public function actionSendFormToRole($form_record_id,$role)
	{
		
		if (!Yii::$app->user->can('api-formrecord-sendformtorole'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$getParams = yii::$app->request->get();
		$form_record = FormRecords::findOne($form_record_id);
		$user = Users::findIdentityByAccessToken($getParams['access-token']);
		
		if(!$form_record)
		{
			return ['status' => 100]; // form record bulunamadı
		}
		$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;
		if($form_record->assign =! $userRole->name)
		{
			return ['status' => 102];//formla ilişkisi olmayan biri formu başkasına assign edemez
		}
		
		$form_record->assign = $role;
		
		if($form_record->save())
		{
			return ['status' => 1]; // form başka kullanıcı grubuna atandı
		}
		
		return ['status' => 101]; // form atama yapılamadı
	}
	
	public function actionGetFormRecordsToRole()
	{
		
		if (!Yii::$app->user->can('api-formrecord-getformrecordtorole'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$getParams = yii::$app->request->get();
		
		$user = Users::findIdentityByAccessToken($getParams['access-token']);
		$data = [];
		
		$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;
		$formRecords = FormRecords::find()->where(['assign' => $userRole->name])->orderBy(['id' => SORT_DESC])->all();
	
		
		if(!$formRecords)
		{
			return ['status' => 100];
		}
		
		$i=0;
		foreach ($formRecords as $formRecord)
			{
				if($formRecord->parents == 0)
				{
					$formRecordSelectedElement = json_decode($formRecord->form->search_result);
					
					$childFormRecords = FormRecords::findAll(['parents' => $formRecord->id]);
					
					$formDataArray = [];
					foreach ($formRecordSelectedElement as $element)
					{
						$formRecordsDatas = FormsData::findOne(['form_record_id' => $formRecord->id,'form_element_id' => $element]);
						
						if(!$formRecordsDatas)
						{
							$form_element_value = json_decode(FormElements::findOne($element)->value);
							array_push($formDataArray,['form_element_id' => $element,'value' => 'Bilinmiyor','label' => $form_element_value->label]);
						}
						else 
						{
							$form_element_value = json_decode(FormElements::findOne($element)->value);
							array_push($formDataArray,['form_element_id' => $formRecordsDatas->form_element_id,'value' => $formRecordsDatas->value,'label' => $form_element_value->label]);
						}
						
					}
					
					$childFormArray = [];
					foreach ($childFormRecords as $childRecord)
					{
						$childRecordSelectedElement = json_decode($childRecord->form->search_result);
						$childFormDataArray = [];
						foreach ($childRecordSelectedElement as $element)
						{
							$formRecordsDatas = FormsData::findOne(['form_record_id' => $formRecord->id,'form_element_id' => $element]);
								
							if(!$formRecordsDatas)
							{
								$form_element_value = json_decode(FormElements::findOne($element)->value);
								array_push($childFormDataArray,['form_element_id' => $element,'value' => 'Bilinmiyor','label' => $form_element_value->label]);
							}
							else
							{
								$form_element_value = json_decode(FormElements::findOne($element)->value);
								array_push($childFormDataArray,['form_element_id' => $formRecordsDatas->form_element_id,'value' => $formRecordsDatas->value,'label' => $form_element_value->label]);
							}
						}
							
						array_push($childFormArray, [
						'id' => $childRecord->id,
						'date' => $childRecord->date,
						'form_id' => $childRecord->form_id,
						'assign' => $childRecord->assign,
						'parents' => $childRecord->parents,
						'form_data' => $childFormDataArray]);
					}
					array_push($data, [
					'id' => $formRecord->id,
					'date' => $formRecord->date,
					'form_id' => $formRecord->form_id,
					'assign' => $formRecord->assign,
					'parents' => $formRecord->parents,
					'form_data' => $formDataArray,
					'form_name' => $formRecord->form->name,
					'child_formrecords' => $childFormArray]);
				}
				else 
				{
					$control = 0;
					foreach ($data as $row)
					{
						if($row['id'] == $formRecord->parents)
						{
							$control = 1;
							break;
						}	
					}
					
					if($control)
					{
						continue;
					}
					
					else 
					{
						$parentFormRecord = FormRecords::findOne($formRecord->parents);
						$formRecordSelectedElement = json_decode($parentFormRecord->form->search_result);
						$childFormRecords = FormRecords::findAll(['parents' => $parentFormRecord->id]);
					
					
						$formDataArray = [];
						foreach ($formRecordSelectedElement as $element)
						{
							$formRecordsDatas = FormsData::findOne(['form_record_id' => $parentFormRecord->id,'form_element_id' => $element]);
							
							if(!$formRecordsDatas)
							{
								$form_element_value = json_decode(FormElements::findOne($element)->value);
								array_push($formDataArray,['form_element_id' => $element,'value' => 'Bilinmiyor','label' => $form_element_value->label]);
							}
							else 
							{
								$form_element_value = json_decode(FormElements::findOne($element)->value);
								array_push($formDataArray,['form_element_id' => $formRecordsDatas->form_element_id,'value' => $formRecordsDatas->value,'label' => $form_element_value->label]);
							}
							
						}
						
						$childFormArray = [];
						foreach ($childFormRecords as $childRecord)
						{
							$childRecordSelectedElement = json_decode($childRecord->form->search_result);
							$childFormDataArray = [];
							foreach ($childRecordSelectedElement as $element)
							{
								$formRecordsDatas = FormsData::findOne(['form_record_id' => $formRecord->id,'form_element_id' => $element]);
									
								if(!$formRecordsDatas)
								{
									$form_element_value = json_decode(FormElements::findOne($element)->value);
									array_push($childFormDataArray,['form_element_id' => $element,'value' => 'Bilinmiyor','label' => $form_element_value->label]);
								}
								else
								{
									$form_element_value = json_decode(FormElements::findOne($element)->value);
									array_push($childFormDataArray,['form_element_id' => $formRecordsDatas->form_element_id,'value' => $formRecordsDatas->value,'label' => $form_element_value->label]);
								}
							}
								
							array_push($childFormArray, [
							'id' => $childRecord->id,
							'date' => $childRecord->date,
							'form_id' => $childRecord->form_id,
							'assign' => $childRecord->assign,
							'parents' => $childRecord->parents,
							'form_data' => $childFormDataArray]);
						}
						array_push($data, [
						'id' => $parentFormRecord->id,
						'date' => $parentFormRecord->date,
						'form_id' => $parentFormRecord->form_id,
						'assign' => $parentFormRecord->assign,
						'parents' => $parentFormRecord->parents,
						'form_data' => $formDataArray,
						'form_name' => $parentFormRecord->form->name." ".$formRecord->form->name,
						'child_formrecords' => $childFormArray]);
					}
				}
					
			
				
				$i++;
			}
		
		
			
		return $data;
	}
	
	public function getChildArray($childArray, $role){
		
		foreach ($childArray as $key => $value) {
			
			if(is_array($childArray[$key]))
			{
				$this->getChildArray($childArray[$key], $role);
			} else {
				
				if (in_array($role, $childArray)) {
					$this->existRole = true;
				}
				
			}
			
			
		}
	}
	
	public function actionFlowUp()
	{
		
		if (!Yii::$app->user->can('api-formrecord-flowup'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$postParams = yii::$app->request->post();
		$getParams = yii::$app->request->get();
		$user = Users::findIdentityByAccessToken($getParams['access-token']);
		
		$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;
		
		if(isset($postParams['form_record_id']) && isset($postParams['roles']))
		{
			$form_record = FormRecords::findOne($postParams['form_record_id']);
			$form = $form_record->form;
			$form_flow = json_decode($form->flow);
			if($form_record->assign != $userRole->name)
			{
				return ['status' => 104];
			}
			
			if(!$form_record)
			{
				return ['status' => 101];
			}
			
			
			
			foreach ($form_flow as $key => $value){
				
				if(is_array($form_flow[$key]))
				{
					$this->getChildArray($form_flow[$key], $postParams['roles']);
				} else {
					if (in_array($postParams['roles'], $form_flow)) {
						$this->existRole = true;
					}
				}
			}
			
			if(!$this->existRole){
				return ['status' => 103]; // yeni assign kaydı yapılamadı
			}
			
			$form_record->assign = $postParams['roles'];
			
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
			
			if($form_record->save())
			{
				return ['status' => 1];
			}
				
			return ['status' => 102];// yeni assign kaydı yapılamadı
			
			
			
			/*foreach ($form_flow as $key => $value)
			{
				
				if(is_array($form_flow[$key]))
				{
					foreach ($form_flow[$key] as $parent_key => $parent_value)
					{
						foreach ($form_flow[$key][$parent_key] as $child_key => $child_value)
						{
							if($child_value == $userRole->name)
							{
								if(isset($form_flow[$key][$parent_key][$child_key+1]))
								{
									$form_record->assign = $form_flow[$key][$parent_key][$child_key+1];
								}
								else
								{
									if(isset($form_flow[$key+1]))
									{
										$form_record->assign = $form_flow[$key+1];
									}
									else
									{
										$form_record->assign = 0;
									}
								}
							
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
							
								if($form_record->save())
								{
									return ['status' => 1];
								}
							
								return ['status' => 102];// yeni assign kaydı yapılamadı
							}
						}
					}
				}
				else 
				{
					if($value == $userRole->name)
					{
						if(isset($form_flow[$key+1]))
						{
							if(is_array($form_flow[$key+1]))
							{
								$form_record->assign = $form_flow[$key+1][0][0];
							}
							else 
							{
								$form_record->assign = $form_flow[$key+1];
							}
						}
								
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
							
						if($form_record->save())
						{
							return ['status' => 1];
						}
							
						return ['status' => 102];// yeni assign kaydı yapılamadı
					}
				}	
			}*/
			
			//return ['status' => 103]; // kişi flow da bulunamadı
		}
		else
		{
			return ['status' => 100]; // parametre hatası
		}
	}
}