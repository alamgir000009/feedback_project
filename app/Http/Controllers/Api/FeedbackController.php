<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $recordPerPage = $request->recordPerPage ?? 10;
        
        $feedbacksList = Feedback::with(['user', 'comments.user'])->paginate($recordPerPage);

        return responseWithSuccess("Feedbacks list fetched successfully", $feedbacksList);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "category" => "required|string|min:5",
            "title" => "required|string",
            "description" => "required|string|min:10",
        ]);

        if ($validator->fails()) {
            return responseWithError($validator->errors(), 422);
        }

        Auth::user()->feedbacks()->create($validator->valid());

        return responseWithSuccess("Feedback added successfully");
    }
    public function feedbackComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "feedback_id" => "required|exists:feedback,id",
            "comment" => "required|string|min:3"
        ]);

        if ($validator->fails()) {
            return responseWithError($validator->errors(), 422);
        }
        
        Auth::user()->comments()->create([
            "comment" => $request->comment,
            "feedback_id" => $request->feedback_id
        ]);

        return responseWithSuccess("Comment is added Successfully");
    }

    public function show($id)
    {
        $feedback = Feedback::with(['user:id,name,image','comments','comments.user'])->find($id);
        return responseWithSuccess("Feedback is fetched Successfully",$feedback);
    }

    public function fetchCategories()
    {
        $categories = Category::select('name')->get();

        return responseWithSuccess("Categories is added Successfully",$categories);
    }

}
