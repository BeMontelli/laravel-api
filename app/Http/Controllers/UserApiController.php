<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',// Minimum length of 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]+$/', // At least one uppercase letter, one lowercase letter, one number, and one special character
                'confirmed', // Requires matching password_confirmation field
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:8',// Minimum length of 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]+$/', // At least one uppercase letter, one lowercase letter, one number, and one special character
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create($request->all());

        return response()->json([
            'message' => 'User created successfully',
            'status' => 'success',
            'data' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::find($user->id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => [
                'required',
                'string',
                'min:8',// Minimum length of 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]+$/', // At least one uppercase letter, one lowercase letter, one number, and one special character
                'confirmed', // Requires matching password_confirmation field
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:8',// Minimum length of 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]+$/', // At least one uppercase letter, one lowercase letter, one number, and one special character
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($user->id);

        if (!$user) {
            return response()->json(['message' => 'User not found', 'status' => 'error'], 404);
        }

        $user->update($request->all());

        return response()->json([
            'message' => 'User updated successfully',
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = User::find($user->id);

        if (!$user) return response()->json(['message' => 'Resource not found', 'status' => 'error'], 404);

        $user->delete();

        return response()->json(['message' => 'Resource deleted successfully', 'status' => 'success'], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => [
                'required',
                'string',
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            if(auth('sanctum')->check()){
                auth()->user()->tokens()->delete();
            }
            $token = Auth::user()->createToken('app_token_'.Auth::user()->id,[
                'create',
                'read',
                'update',
                'delete',
            ])->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'status' => 'success',
                'data' => [
                    "user" => Auth::user(),
                    "token" => $token
                ]
            ]);
        } else {
            return response()->json(['message' => 'Unauthorized', 'status' => 'error'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',// Minimum length of 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]+$/', // At least one uppercase letter, one lowercase letter, one number, and one special character
                'confirmed', // Requires matching password_confirmation field
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:8',// Minimum length of 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]+$/', // At least one uppercase letter, one lowercase letter, one number, and one special character
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create($request->all());

        $token = $user->createToken('app_token_'.$user->id,[
            'create',
            'read',
            'update',
            'delete',
        ])->plainTextToken;

        return response()->json([
            'message' => 'User created successfully',
            'status' => 'success',
            'data' => [
                "user" => $user,
                "token" => $token
            ]
        ], 201);
    }
}
