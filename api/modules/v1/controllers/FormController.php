<?php

namespace api\modules\v1\controllers;

use Yii;
use \yii\rest\Controller;
use api\modules\v1\models\Forms;
use vendor\diginova\rbac\models\AuthAssignment;
use yii\web\UnauthorizedHttpException;

class FormController extends Controller {
	
	public $modelClass = 'api\modules\v1\models\Forms';

	
	
	public function actions() {
		$actions = parent::actions ();
		
		// disable the "delete" and actions
		unset ( $actions ['delete'] );
		
		return $actions;
	}
	
	public function actionIndex()
	{
		
		if (!Yii::$app->user->can('api-forms-index'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$forms = Forms::find()->all();
		
		if (!$forms) {
			return ['status' => 100]; // form yok
		}
		
		$formsArray = [];
		foreach ($forms as $value) {
			array_push($formsArray, [
					'id' => $value->id,
					'name' => $value->name,
					'date' => $value->date,
					'parent' => $value->parent,
					'search_element' => $value->search_element,
					'flow' => $value->flow,
					'type' => $value->type,
					'use_roles' => $value->use_roles,
					'create_roles' => $value->create_roles,
				]
			);
		}
		
		return $formsArray;

		
	}
	
	public function actionGetChildForms($formID)
	{
		if (!Yii::$app->user->can('api-forms-getchildforms'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$forms = Forms::find()->where(['parent' => $formID])->all();
		
		if (!$forms) {
			return ['status' => 100]; // form yok
		}
		
		$formsArray = [];
		foreach ($forms as $value) {
			array_push($formsArray, [
			'id' => $value->id,
			'name' => $value->name,
			'date' => $value->date,
			'parent' => $value->parent,
			'search_element' => $value->search_element,
			'flow' => $value->flow,
			'type' => $value->type,
			]
			);
		}
		
		return $formsArray;
	}
	
	public function actionFormControl($formID)
	{
		if (!Yii::$app->user->can('api-forms-formcontrol'))
			throw new UnauthorizedHttpException('Authentication failed.');
		
		$postParams = yii::$app->request->post();
		$form = Forms::findOne($formID);
		
		
		if(!$form)
		{
			return ['status' => 100];
		}
		
		if($form->date == $postParams['date'])
		{
			return ['status' => 1];
		}
		
		return ['status' => 0];
	}
	

}