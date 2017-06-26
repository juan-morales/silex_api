<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController{

	protected $productService;
	protected $app;
	
	public function __construct($app, $services) {
		/*
			All the services asociated to Products, are store in a protected variable, so hey be used in the controller logic.
		*/
		$this->productService = $services['ProductService'];
		$this->app = $app;
	}

	public function index(Request $request) {
		/*
			List the products or list the product by product_id
		*/
		
		$data = $request->request->all();
		
		/*
			check if product_id was provided in the request, otherwise, set it to null
		*/
		if (!isset($data['product_id']))
		{
			$data['product_id'] = null;
		}

		/* 
			Execute the service method 
		*/
		try {

			$result = $this->productService->index($data['product_id']);	

		} catch (Exception $e) {
			return new JsonResponse(array(
				'msg' => 'ERROR: Trying to retrieve list of products ',
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

	public function create(Request $request) {
		/*
			create a product.
			check if there is another product with the same name before
		*/

		$data = $request->request->all();

		if (!isset($data['product_name']))
		{
			return new JsonResponse(array(
				'msg' => 'Parameter "product_name" is required.',
				'code' => 200,
				'error' => true,
			));
		}

		$pname_found = $this->productService->selectByName($data['product_name']);

		if ($pname_found) 
		{
			return new JsonResponse(array(
				'msg' => 'There is a product with exactly the same name.',
				'code' => 200,
				'error' => true,
			));
		}

		/*
			Create an array with the nec. fields.
			In this case, Table Products has only 1 column, that would be "name" for product name.
		*/

		$new_product = array(
			'name' => $data['product_name'],
		);
		
		try {
			$result = $this->productService->create($new_product);	
		} catch (Exception $e) {
			return new JsonResponse(array(
				'msg' => 'Exception ERROR: imposible to create a product.',
				'code' => 200,
				'error' => true,
				'ex' => $e->getMessage(),
			));
		}
		
		if (!$result) {
			return new JsonResponse(array(
				'msg' => 'ERROR: creating new Product.',
				'code' => 200,
				'error' => true,
			)); 
		}

		return new JsonResponse(array(
			'msg' => 'OK',
			'code' => 200,
			'error' => false,
			'data' => $result,
		)); 
	}
	
	public function delete(Request $request) {
		
		$data = $request->request->all();

		if (!isset($data['product_id']))
		{
			return new JsonResponse(array(
				'msg' => 'Parameter "product_id" is required.',
				'code' => 200,
				'error' => true,
			));
		}
		
		try {
			$result = $this->productService->delete($data['product_id']);
		} catch (Exception $e) {
			return new JsonResponse(array(
				'msg' => 'Exception ERROR: imposible to delete a product.',
				'code' => 200,
				'error' => true,
				'ex' => $e->getMessage(),
			));
		}

		
		if (!$result) {
			return new JsonResponse(array(
				'msg' => 'ERROR: deleting a Product.',
				'code' => 200,
				'error' => true,
			)); 
		}

		return new JsonResponse(array(
			'msg' => 'OK',
			'code' => 200,
			'error' => false,
			'data' => $result,
		)); 
	}
	
	public function update(Request $request) {

		$data = $request->request->all();

		if (!isset($data['product_id']))
		{
			return new JsonResponse(array(
				'msg' => 'Parameter "product_id" is required.',
				'code' => 200,
				'error' => true,
			));
		}
		
		if (!isset($data['product_name']))
		{
			return new JsonResponse(array(
				'msg' => 'Parameter "product_name" is required.',
				'code' => 200,
				'error' => true,
			));
		}

		$pname_found = $this->productService->selectByName($data['product_name']);

		if ($pname_found) 
		{
			return new JsonResponse(array(
				'msg' => 'There is a product with exactly the same name.',
				'code' => 200,
				'error' => true,
			));
		}

		$new_product = array(
			'name' => $data['product_name'],
		);

		try {
			$result = $this->productService->update($data['product_id'],$new_product);	
		} catch (Exception $e) {
			return new JsonResponse(array(
				'msg' => 'Exception ERROR: imposible to update a product.',
				'code' => 200,
				'error' => true,
				'ex' => $e->getMessage(),
			));
		}
		
		if (!$result) {
			return new JsonResponse(array(
				'msg' => 'ERROR: creating new Product.',
				'code' => 200,
				'error' => true,
			)); 
		}

		return new JsonResponse(array(
			'msg' => 'OK',
			'code' => 200,
			'error' => false,
			'data' => $result,
		)); 
	}
}
