<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
	
	public function getMe()
	{
		return Auth::check() ?
			$this->respondSuccess([
				'user' => Auth::user()
			]) :
			$this->respondUnauthorized('Unauthenticated.');
	}
	
	public function login(Request $request)
	{
		$credentials = $request->validate([
			'email' => 'required|email',
			'password' => 'required'
		]);
		
		if( Auth::attempt($credentials) ) {
			$user = Auth::user();
			return $this->respondSuccess(['email' => $user->email, 'csrf_token' => csrf_token()]);
		}
		
		return $this->respondUnauthorized('Please check your email and/or password.');
	}
	
	public function logout()
	{
		Auth::guard('web')->logout();
		
		return Auth::guard('web')->check() ?
			$this->respondUnauthorized() :
			$this->respondSuccess(null);
	}
	
}
