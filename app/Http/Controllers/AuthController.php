<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegisterFormRequest;

class AuthController extends Controller
{
    public function signUp(RegisterFormRequest $request)
    {

    	User::create([
    		'name'		=> $request->json('name'),
    		'email'		=> $request->json('email'),
    		'password'	=> bcrypt($request->json('password'))
    	]);
    }

    public function signin(Request $request)
    {
    	/**
    	 * Catch JWT Exception
    	 */
    	try {
    		$token = JWTAuth::attempt($request->only('email', 'password'), [
    			'exp'	=> Carbon::now()->addWeek()->timestamp,
    		]);
    	} catch (JWTException $e) {
    		return response()->json([
    			'error'	=> 'Could not authernicate',
    		], 500);
    	}

    	/**
    	 * Check if there is no token
    	 */
    	if (!$token) {
    		return response()->json([
    			'error' => 'Could not authernicate',
    		]);
    	}

    	return response()->json(compact('token'));
    }
}
