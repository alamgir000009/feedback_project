<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name')->get();
        return responseWithSuccess("Users fetched successfully", $users);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => 'required|min:5|confirmed',
            "image" => "nullable|mimes:png,jpeg,jpg",
        ]);

        if ($validator->fails()) {
            return responseWithError($validator->errors(), 422);
        }

        if($request->image)
        {
            $path = $request->image->store("user_profiles", "public");
            $validator->valid()['image'] = explode("user_profiles/",$path)[1];
        }

        $user = User::create($validator->valid());

        $token = $user->createToken('sanctum_api_token')->plainTextToken;

        $data = ["token" => $token, "user" => $user];

        return responseWithSuccess("Register Successful", $data);
    }

    public function login(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validators->fails()) {
            return responseWithError($validators->errors(), 422);
        }

        if (Auth::attempt($request->only('email', 'password'))) 
        {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('API Token')->plainTextToken;
            $data = ["token" => $token, "user" => $user];
            return responseWithSuccess("User logged in Successfully", $data);

        } else {
            return responseWithError("Credentials does not match our record", 421);
        }
    }

    public function logout()
    {
        if (auth()->user()) {
            auth()->user()->currentAccessToken()->delete();
        }
        return responseWithSuccess("Logout Successfully!", true);

    }
}
