<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Routing\UrlGenerator;
use File;
use Auth;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    protected $orders;


    public function __construct(UrlGenerator $urlGenerator)
    {

        $this->orders = new Order;
    }
    public function index(Request $request)
    {
        /** @var User $user  */
        $orders = $this->orders->where("user_id", $request->user_id)->get()->toArray();

        return response()->json([
            "success" => true,
            "data" => $orders,

        ], 200);
    }

    public function show($id)
    {
        $findData = $this->orders::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "order with this id doesnt exist"
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


                "tickets_id" => ['required', 'exists:tickets,id'],
                'user_id' => ['required', 'exists:users,id'],

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }






        $this->orders->user_id = $request->user_id;
        $this->orders->tickets_id = $request->tickets_id;

        $this->orders->save();

        return response()->json([
            "success" => true,
            "message" => "orders saved successfully"
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "tickets_id" => ['required', 'exists:tickets,id'],
                'user_id' => ['required', 'exists:users,id'],
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }
        $this->orders->user_id = $request->user_id;
        $this->orders->tickets_id = $request->tickets_id;


        $findData = $this->orders->find($id);
        if (!$findData) {
            return response()->json([
                "success" => false,
                "message" => "please this content has no valid id"
            ], 400);
        }





        $findData->user_id = $request->user_id;

        $findData->tickets_id = $request->tickets_id;



        $findData->save();





        return response()->json([
            "success" => true,
            "message" => "orders updated successfully",
        ], 200);
    }

    public function destroy($id)
    {
        $findData = $this->orders::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "order with this id doesnt exist"
            ], 500);
        }
        if ($findData->delete()) {


            return response()->json([
                "success" => true,
                "message" => "orders deleted successfully"
            ], 200);
        }
        
    }
}
