<?php

namespace api\modules\v1\controllers;

use Yii;
use \yii\rest\Controller;
use api\modules\v1\models\FormElements;
use yii\web\UploadedFile;
use common\models\Users;
use api\modules\v1\models\FormsData;
use api\modules\v1\models\Forms;
use api\modules\v1\models\FormsElementRoles;
use yii\base\Security;
use yii\base\Object;
use vendor\diginova\rbac\models\AuthAssignment;
use yii\web\UnauthorizedHttpException;

class FormelementController extends Controller {
	
	public $modelClass = 'api\modules\v1\models\FormElements';
		
	public $mainArray = [];
	public $childArray = [];
	public $subChildArray = [];
	
	
	public function actions() {
		$actions = parent::actions ();		
		return $actions;
	}
	
	public function actionIndex($formID){
		
		if (!Yii::$app->user->can('api-formelement-index'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$getParams = yii::$app->request->get();
		$user = Users::findIdentityByAccessToken($getParams['access-token']);
		$parentZero = $this->findChild(0,$formID);


		
		foreach ($parentZero as $baseParent) {
			$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;  
			$role = FormsElementRoles::findOne(['element_id' => $baseParent->id,'role' => $userRole->name]);

			if($role)
			{
				if($role->permission == 1 || $role->permission == 2 || $role->permission == 3)
				{

					$child = $this->findChild($baseParent->id,$formID);
					
					if (!$child)
					{
						array_push($this->mainArray, ['id' => $baseParent->id, 'parent' => $baseParent->parent, 'type' => $baseParent->type, 'order' => $baseParent->order, 'required' => $baseParent->required, 'value' => $baseParent->value, 'permission' => $role->permission]);
					} else
					{
						$childArray = $this->editChildArray($child, $this->childArray,$user);
	
						array_push($this->mainArray, ['id' => $baseParent->id, 'parent' => $baseParent->parent, 'type' => $baseParent->type, 'value' => $baseParent->value, 'order' => $baseParent->order, 'required' => $baseParent->required,'permission' => $role->permission, 'child' => $childArray]);	
					}
				}
			}

		}
		
		if(!$this->mainArray)
			return ['status' => 100];

		return $this->mainArray;
		
	}
	
	public function actionGetFormSearchElement($formID) {
		
		if (!Yii::$app->user->can('api-formelement-getsearchelement'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$form = Forms::findOne($formID);
		
		if (!$form) {
			return ['status' => 101];
		}
		
		$data = json_decode($form->search_element);
		
		$formElements = FormElements::findAll($data);
		
		if (!$formElements) {
			return ['status' => 100];
		}
		
		$justSource = [];
		
		foreach ($formElements as $value) {
			array_push($justSource, ["form_element_id" => $value->id, "value" => $value->value, "type" => $value->type]);
		}
		
		return $justSource;
	}
	
	public function findChild($parent,$formID){
		return FormElements::find()
			->where(['parent' => $parent,'form_id' => $formID])
			->orderBy('order')
			->all();
	}
	
	public function editChildArray($childData, $childArray,$user){
		
		foreach ($childData as $childInfo) {
			
			$userRole = AuthAssignment::findOne(['user_id' => $user->id])->itemName;  // @muco : Bu kısımda önceden user rollerine göre denetim yapılıyormuş.
			$role = FormsElementRoles::findOne(['element_id' => $childInfo->id,'role' => $userRole->name]);
			
			$childSub = $this->findChild($childInfo->id,$childInfo->form_id);
			
			if(!$role)
			{	
				$role = FormsElementRoles::findOne(['element_id' => $childInfo->parent,'role' => $userRole->name]);
				if(!$role)
				{
					$element = FormElements::findOne($childInfo->parent);
					$role = FormsElementRoles::findOne(['element_id' => $element->parent,'role' => $userRole->name]);
				}
			}
			if($role)
			{
				if($role->permission == 1 || $role->permission == 2)
				{
					if (!$childSub)
					{
						if($childInfo->type == 16)
						{
							$dropdownList = $this->editDropdownList($childInfo);
							$dropdownList['permission'] = $role->permission;
							array_push($childArray, $dropdownList);
						}
						else
							array_push($childArray, ['id' => $childInfo->id, 'parent' => $childInfo->parent, 'type' => $childInfo->type, 'order' => $childInfo->order, 'required' => $childInfo->required, 'value' => $childInfo->value ,'permission' => $role->permission]);
					}
					else
					{
						$childArraySub = $this->editChildArray($childSub, $this->subChildArray,$user);
						array_push($childArray, ['id' => $childInfo->id, 'parent' => $childInfo->parent, 'type' => $childInfo->type, 'order' => $childInfo->order, 'required' => $childInfo->required, 'value' => $childInfo->value,'permission' => $role->permission, 'child' => $childArraySub]);
					}
				}
			}
				
		}
		return $childArray;
	}
	
	public function editDropdownList(Object $childInfo)
	{
		$value = json_decode($childInfo->value);
		$doctors = Users::findAll(['role' => $value->role]);
		$doctors_name = [];
		foreach ($doctors as $doctor)
		{
			$name = $doctor->firstname." ".$doctor->lastname;
			array_push($doctors_name, $name);
		}
		$value->source = $doctors_name;
		
		return ['id' => $childInfo->id, 'parent' => $childInfo->parent, 'type' => $childInfo->type, 'order' => $childInfo->order, 'required' => $childInfo->required, 'value' => json_encode($value)];
	}
	
	public function actionCreate()
	{
		$getParams = yii::$app->request->get();
		$postParams = yii::$app->request->post();
		
		$user = Users::findIdentityByAccessToken($getParams['access-token']);
		
		$decoded_array = json_decode($postParams['data']);
		$form_data = $decoded_array->form_data;
		$elements = $decoded_array->elements;
		
		$form = new Forms();
		
		$form->name = $form_data->name;
		$form->type = isset($form_data->type) ? $form_data->type : 1;
		$form->parent = $form_data->parent;
		$form->date = date("Y-m-d h:i:s");
		$form->search_element = $form_data->search_element;
		$form->search_result = $form_data->search_result;
		$form->flow = $form_data->flow;
		$form->use_roles = $form_data->use_roles;
		$form->create_roles = $form_data->create_roles;
		$form->save();
		
		foreach($elements as $tab)
		{
			$new_tab = new FormElements();
			$value = [];
			$value['label'] = $tab->label;
			$new_tab->type = 1;
			$new_tab->parent = 0;
			$new_tab->value = json_encode($value);
			$new_tab->order = $tab->order;
			$new_tab->required = 1;
			$new_tab->form_id = $form->id;
			$new_tab->key = "0";
			$new_tab->save();
			
			foreach($tab->child as $section)
			{
				$new_section = new FormElements();
				$value = [];
				$value['label'] = $section->label;
				if(isset($section->section_type))
				{
					$value['section_type'] = 1;
					$value['elements'] = $section->elements;
				}
				$new_section->value = json_encode($value);
				$new_section->order = $section->order;
				$new_section->type = 2;
				$new_section->parent = $new_tab->id;
				$new_section->required = 1;
				$new_section->key = "0";
				$new_section->form_id = $form->id;
				$new_section->save();

				foreach($section->child as $form_element)
				{
					$new_form_element = new FormElements();
					$value = [];
					
					$new_form_element->type = $form_element->type;
					$new_form_element->order = $form_element->order;
					$new_form_element->parent = $new_section->id;
					$new_form_element->required = 0;
					$new_form_element->key = "0";
					$new_form_element->form_id = $form->id;
					switch($form_element->type)
					{
						case 3:{
							$value['source'] = $form_element->options;
							$value['label'] = $form_element->label;
							
						}
						case 5:{
							if(isset($form_element->process))
							{
								$value['source'] = [];
								$value['process'] = $form_element->process;
							}
							else 
							{
								$value['source'] = [];
								$value['text_type'] = $form_element->text_type;
								$value['regex'] = $form_element->regex;
								$value['hint'] = $form_element->hint;
								$value['err_message'] = $form_element->err_message;
								$value['text_type'] = $form_element->text_type;
								if(isset($form_element->conditions))
									$value['conditions'] = $form_element->conditions;
								
							}
						}
					}
					$new_form_element->value = json_encode($value);
					$new_form_element->save();
					print_r($new_form_element);
					
				}
			}
			
			
		}
		
	}
	
	
}