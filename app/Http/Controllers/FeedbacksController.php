<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Routing\UrlGenerator;
use File;
use Auth;
use Illuminate\Support\Facades\Validator;

class FeedbacksController extends Controller
{
    protected $feedbacks;


    public function __construct(UrlGenerator $urlGenerator)
    {

        $this->feedbacks = new Feedback;
    }
    public function index($user_id)
    {
        /** @var User $user  */
        $feedbacks = $this->feedbacks->where("user_id", $user_id)->get()->toArray();

        return response()->json([
            "success" => true,
            "data" => $feedbacks,

        ], 200);
    }

    public function show($id)
    {
        $findData = $this->feedbacks::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "feedback with this id doesnt exist"
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


                "comments" => "required|string",
                'user_id' => ['required', 'exists:users,id'],

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }






        $this->feedbacks->user_id = $request->user_id;
        $this->feedbacks->comments = $request->comments;

        $this->feedbacks->save();

        return response()->json([
            "success" => true,
            "message" => "feedbacks saved successfully"
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'comments' => 'required|string',
                'user_id' => ['required', 'exists:users,id'],
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->toArray()
            ], 400);
        }
        $this->feedbacks->user_id = $request->user_id;
        $this->feedbacks->comments = $request->comments;


        $findData = $this->feedbacks->find($id);
        if (!$findData) {
            return response()->json([
                "success" => false,
                "message" => "please this content has no valid id"
            ], 400);
        }





        $findData->user_id = $request->user_id;

        $findData->comments = $request->comments;



        $findData->save();





        return response()->json([
            "success" => true,
            "message" => "feedbacks updated successfully",
        ], 200);
    }

    public function destroy($id)
    {
        $findData = $this->feedbacks::find($id);
        if (!$findData) {

            return response()->json([
                "success" => true,
                "message" => "feedback with this id doesnt exist"
            ], 500);
        }
        if ($findData->delete()) {


            return response()->json([
                "success" => true,
                "message" => "feedbacks deleted successfully"
            ], 200);
        }
        
    }
}
