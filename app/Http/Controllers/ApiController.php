<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
	protected int $status_code = Response::HTTP_OK;
	
	/**
	 * @return int
	 */
	public function getStatusCode(): int
	{
		return $this->status_code;
	}
	
	/**
	 * @param $statusCode
	 * @return $this
	 */
	public function setStatusCode($statusCode): ApiController
	{
		$this->status_code = $statusCode;
		return $this;
	}
	
	/**
	 * @param array $data
	 * @param array $headers
	 * @return mixed
	 */
	public function respond(array $data, array $headers = []): JsonResponse
	{
		return response()->json($data, $this->getStatusCode(), $headers);
	}
	
	/**
	 * @param $data
	 * @param string $message
	 * @return JsonResponse|mixed
	 */
	public function respondSuccess($data, string $message = 'Success.')
	{
		$this->setStatusCode(Response::HTTP_OK);
		
		return $this->respond([
			'message' => $message,
			'data' => $data
		]);
	}
	
	/**
	 * @param $data
	 * @param string $message
	 * @return JsonResponse
	 */
	public function respondCreated($data, string $message = 'Created.'): JsonResponse
	{
		$this->setStatusCode(Response::HTTP_CREATED);
		
		return $this->respond([
			'message' => $message,
			'data' => $data
		]);
	}
	
	/**
	 * @param string $message
	 * @return JsonResponse|mixed
	 */
	public function respondInternalError(string $message = 'Whoops, something went wrong.')
	{
		$this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
		
		return $this->respond([
			'message' => $message,
		]);
	}
	
	/**
	 * @param $errors
	 * @param string $message
	 * @return JsonResponse|mixed
	 */
	public function respondValidationError($errors, string $message = 'Invalid data.')
	{
		$this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
		
		return $this->respond([
			'message' => $message,
			'errors' => $errors
		]);
	}
	
	/**
	 * @param string $message
	 * @return JsonResponse
	 */
	public function respondNotFound(string $message = 'Resource not found.'): JsonResponse
	{
		return $this->respond([
			'message' => $message
		]);
	}
	
	/**
	 * @param string $message
	 * @return JsonResponse
	 */
	public function respondUnauthorized(string $message = 'Unauthorized.') : JsonResponse
	{
		$this->setStatusCode(Response::HTTP_FORBIDDEN);
		
		return $this->respond([
			'status' => 'forbidden',
			'status_code' => $this->getStatusCode(),
			'message' => $message,
		]);
	}
	
}
