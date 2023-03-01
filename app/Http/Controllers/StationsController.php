<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Models\Station;
use Illuminate\Routing\UrlGenerator;
use File;
use Auth;
use Illuminate\Support\Facades\Validator;

class StationsController extends Controller
{
    protected $stations;


    public function __construct(UrlGenerator $urlGenerator)
    {

        $this->stations = new Station;
    }
    public function index(Request $request)
    {
        /** @var Station $station  */
        $stations = $this->stations->get()->toArray();

        return response()->json([
            "success" => true,
            "data" => $stations,

        ], 200);
    }

    public function show($id)
    {
        $findData = $this->stations::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "station with this id doesnt exist"
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

               
                'location' => 'required|string',
                'number' => 'required|string',
                

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }






       
        $this->stations->location = $request->location;
        $this->stations->number = $request->number;


        $this->stations->save();

        return response()->json([
            "success" => true,
            "message" => "stations saved successfully"
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
               
                'location' => 'required|string',
                'number' => 'required|string',
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }


        $findData = $this->stations->find($id);
        if (!$findData) {
            return response()->json([
                "success" => false,
                "message" => "please this content has no valid id"
            ], 400);
        }





       
        $findData->location = $request->location;
        $findData->number = $request->number;
        
        $findData->save();



        return response()->json([
            "success" => true,
            "message" => "stations updated successfully",
        ], 200);
    }

    public function destroy($id)
    {
        $findData = $this->stations::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "station with this id doesnt exist"
            ], 500);
        }
        if ($findData->delete()) {


            return response()->json([
                "success" => true,
                "message" => "stations deleted successfully"
            ], 200);
        }
      
        
    }
}