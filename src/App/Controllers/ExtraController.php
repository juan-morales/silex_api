<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ExtraController{

	protected $extraService;
	protected $app;
	
	public function __construct($app, $services) {
		/*
			All the services asociated to Products, are store in a protected variable, so hey be used in the controller logic.
		*/
		$this->extraService = $services['ExtraService'];
		$this->app = $app;
	}

	public function index(Request $request) {
		/*
			List the products or list the product by product_id
		*/
		
		$data = $request->request->all();
		
		/*
			check if was provided in the request, otherwise, set it to null
		*/

		if (!isset($data['name']))
		{
			$data['name'] = null;
		}

		/* 
			Execute the service method 
		*/
		try {

			$result = $this->extraService->index($data['name']);	

		} catch (Exception $e) {
			return new JsonResponse(array(
				'msg' => 'Exception ERROR: Trying to Hello you. ;) ',
				'code' => 200,
				'error' => true,
				'ex' => $e->getMessage(), 
			));
		}
		
		/*
			if we do not have results, then response a JSON structured properly build to express errors o results  
		*/
		return new JsonResponse(array(
			'msg' => 'OK: Query executed.',
			'code' => 200,
			'error' => false,
			'data' => $result,
		));
	}

	
}
