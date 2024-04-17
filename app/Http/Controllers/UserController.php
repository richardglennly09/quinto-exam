<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //

    public function index() {
        return response()->json([
           'data' => User::all()
        ], 200);
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $data = $request->input();

            User::create([
               "name" => $data['name'],
               "email" => $data['email'],
               "password" => 'password',
            ]);

            DB::commit();
            return response()->json([
                'message' => 'User created successfully'

            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage()

            ], 500);
            //throw $th;
        }
    }

    public function update($id, Request $request) {
        DB::beginTransaction();
        try {
            $data = $request->input();

            User::find($id)->update([
               "name" => $data['name'],
               "email" => $data['email'],
            ]);

            DB::commit();
            return response()->json([
                'message' => 'User updated successfully'

            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage()

            ], 500);
            //throw $th;
        }
    }

    public function login(Request $request) {
        $data = $request->input();

        $user = User::whereEmail($data['email'])->first();

        if($user) {
            $token = $user->createToken('remember_token')->accessToken;

            return response()->json([
                'token' => $token
            ], 201);
        } else {
            return response()->json([
                'message' => "User not found."
            ], 401);
        }
    }
}
