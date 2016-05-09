<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Redirect;

use Validator;

use App\Comment;

use Auth;

class CommentController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }
    
    public function validator($data) 
 	{
 		return Validator::make($data, [
            'comment' => 'required|min:10|max:140'            
        ]);
 	}

    public function store(Request $request) 
    {
    	$data = $request->only(['comment','collection_id']);    	
    	$validator = $this->validator($data);
    	if($validator->fails()) {
    		return Redirect::back()->withErrors($validator);     		
    	} else {
    		$comment = new Comment;
    		$comment->user_id = Auth::user()->id;
    		$comment->collection_id = $data['collection_id'];
    		$comment->comment = $data['comment'];
    		$comment->save();
            return Redirect::back();
    	}
    }
}
