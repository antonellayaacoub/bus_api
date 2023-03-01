<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Routing\UrlGenerator;
use File;
use Auth;
use Illuminate\Support\Facades\Validator;

class TicketsController extends Controller
{
    protected $tickets;


    public function __construct(UrlGenerator $urlGenerator)
    {

        $this->tickets = new Ticket;
    }
    public function index(Request $request)
    {
        /** @var Ticket $ticket  */
        $tickets = $this->tickets->get()->toArray();

        return response()->json([
            "success" => true,
            "data" => $tickets,

        ], 200);
    }

    public function show($id)
    {
        $findData = $this->tickets::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "ticket with this id doesnt exist"
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

                'price' => 'required|string',
                'from' => 'required|string',
                'to' => 'required|string',
                'time' => 'required|string',
                "station_id" => ['required', 'exists:stations,id'],


            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }






        $this->tickets->price = $request->price;
        $this->tickets->from = $request->from;
        $this->tickets->to = $request->to;
        $this->tickets->time = $request->time;
        $this->tickets->station_id = $request->station_id;


        $this->tickets->save();

        return response()->json([
            "success" => true,
            "message" => "tickets saved successfully"
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'price' => 'required|string',
                'from' => 'required|string',
                'to' => 'required|string',
                'time' => 'required|string',
                "station_id" => ['required', 'exists:stations,id'],

            ]
        );


        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }


        $findData = $this->tickets->find($id);
        if (!$findData) {
            return response()->json([
                "success" => false,
                "message" => "please this content has no valid id"
            ], 400);
        }





        $findData->price = $request->price;
        $findData->from = $request->from;
        $findData->to = $request->to;
        $findData->time = $request->time;
        $$findData->station_id = $request->station_id;

        $findData->save();


        return response()->json([
            "success" => true,
            "message" => "tickets updated successfully",
        ], 200);
    }

    public function destroy($id)
    {
        $findData = $this->tickets::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "ticket with this id doesnt exist"
            ], 500);
        }
        if ($findData->delete()) {


            return response()->json([
                "success" => true,
                "message" => "tickets deleted successfully"
            ], 200);
        }


    }
}