<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\UrlGenerator;
use File;
use Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    protected $users;


    public function __construct(UrlGenerator $urlGenerator)
    {

        $this->users = new User;
    }
    public function index($status)
    {
        /** @var User $user  */

        $users = $this->users->where("status", $status)->get()->toArray();

        return response()->json([
            "success" => true,
            "data" => $users,

        ], 200);
    }

    public function show($id)
    {
        $findData = $this->users::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "user with this id doesnt exist"
            ], 500);
        }
        return response()->json([
            "success" => true,
            "data" => $findData,
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'fullname' => 'required|string',
                'email' => 'required|string',
                'password' => 'required|string',
                'status' => 'required|string',
                'number' => 'required|string',
                'institution' => 'required|string',
                'busnumber' => 'required|string',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }






        $this->users->fullname = $request->fullname;
        $this->users->email = $request->email;
        $this->users->password = $request->password;
        $this->users->status = $request->status;

        $this->users->number = $request->number;

        $this->users->institution = $request->institution;


        $this->users->busnumber = $request->busnumber;


        $this->users->save();

        return response()->json([
            "success" => true,
            "message" => "users saved successfully"
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required|string',
                'email' => 'required|string',
                'password' => 'required|string',
                'status' => 'required|string',
                'number' => 'required|string',
                'institution' => 'required|string',
                'busnumber' => 'required|string',
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }


        $findData = $this->users->find($id);
        if (!$findData) {
            return response()->json([
                "success" => false,
                "message" => "please this content has no valid id"
            ], 400);
        }





        $findData->fullname = $request->fullname;
        $findData->email = $request->email;
        $findData->password = $request->password;
        $findData->status = $request->status;
        $findData->number = $request->number;
        $findData->institution = $request->institution;
        $findData->busnumber = $request->busnumber;

        $findData->save();



        return response()->json([
            "success" => true,
            "message" => "users updated successfully",
        ], 200);
    }

    public function destroy($id)
    {
        $findData = $this->users::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "user with this id doesnt exist"
            ], 500);
        }
        if ($findData->delete()) {


            return response()->json([
                "success" => true,
                "message" => "users deleted successfully"
            ], 200);
        }


    }
}