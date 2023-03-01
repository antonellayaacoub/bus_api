<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    //
    protected $user;


 public function __construct()
 {
   $this->user = new User;
 }



 public function register(Request $request)
 {

    $validator = Validator::make($request->all(),
    [
      'name'=>'required|string',
      'email'=>'required|email',
      'password'=>'required|string|min:6',
    ]);

    if($validator->fails())
    {
     return response()->json([
         "success"=>false,
         "message"=>$validator->messages()->toArray(),
         "error"=>$validator->messages()->toArray()
     ],400);
    }

    $check_email = $this->user->where("email",$request->email)->count();
    if($check_email > 0)
    {
        return response()->json([
        'success'=>false,
        'error'=>'this email already exist please try another email',
        'message'=>'this email already exist please try another email'
        ],200);

    }


   $registerComplete = $this->user->create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=> Hash::make($request->password),
    ]);

    return response()->json([
      'success'=>true,
      'message'=>'registration completed successfully'
      ],200);
    //
    //   if($registerComplete)
    //   {
    //      return $this->login($request);
    //   }
 }




 public function login(Request $request)
 {
     $validator = Validator::make($request->only('email','password'),
     [
        'email'=>'required|email',
        'password'=>'required|string|min:6',
     ]
     );

     if($validator->fails())
    {
     return response()->json([
         "success"=>false,
         "error"=>$validator->messages()->toArray(),
         "message"=>$validator->messages()->toArray(),
     ],400);
    }

 

    $input = $request->only("email","password");

  

return response()->json([
  'success'=>true,
 ]);
}


}
