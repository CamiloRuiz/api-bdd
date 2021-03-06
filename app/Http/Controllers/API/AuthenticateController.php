<?php
namespace App\Http\Controllers\API;

use JWTAuth;
use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{
    public function store(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'invalid_credentials'
                ], 401);
            } else {
                $user = array(
                    'id' => 1,
                    'firstname' => 'Jhon',
                    'lastname' => 'Doe',
                    'email' => 'cristian@gmail.com',
                    'picture_url' => 'http://asdf/indw/jorge.jpg'
                );
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                'error' => 'could_not_create_token'
            ], 500);
        }
        // No errors, return the token
        return response()->json(compact('token', 'user'));
    }
}
