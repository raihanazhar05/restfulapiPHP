<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $r){
        $data=$r->validate([
            'name'=>'required','email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',
        ]);
        $user=User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password']),
        ]);
        return response()->json(['user'=>$user,'token'=>$user->createToken('api-token')->plainTextToken],201);
    }

    public function login(Request $r){
        $data=$r->validate(['email'=>'required|email','password'=>'required']);
        $user=User::where('email',$data['email'])->first();
        if(!$user || !Hash::check($data['password'],$user->password)){
            throw ValidationException::withMessages(['email'=>['Invalid credentials.']]);
        }
        $user->tokens()->delete(); // optional: single-session
        return ['token'=>$user->createToken('api-token')->plainTextToken];
    }

    public function logout(Request $r){
        $r->user()->currentAccessToken()->delete();
        return ['message'=>'Logged out'];
    }
}
