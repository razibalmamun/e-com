<?php

namespace App\Http\Controllers\Auth;

use DB;
use Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Http\Resources\UserResource;
use App\Services\ApiResponseService;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'role' => $request->input('role')])) {
            $user = Auth::user();
            $token =  $user->createToken($user->email)->plainTextToken;
            return $this->respondWithToken($token, $user, null);
        } else {
            return $this->respondWithUnauthorisedError('User ID or Password mismatch');
        }
    }

    public function registration(ApiResponseService $apiResponseService, RegistrationRequest $request, User $user) {
        $fillableData = $request->only($user->getFillable());
        $user->fill($fillableData)->save();
        $single = new UserResource($user);
        return $apiResponseService->efflux($single);
    }

    public function me(Request $request)
    {
        $user = Auth::user();
        return $this->respond([
            'status' => 1,
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->respond(['message' => 'Successfully Logged Out.']);
    }

}
