<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;

use App\User;

use Response;
class SearchController extends Controller
{
    public function query() {    	
		$query = Input::get('user');		
        $res   = User::where('name', 'LIKE', "%$query%")->get();
        return Response::json($res);
    }

    public function show(Request $request) {    	
    	return redirect()->route('profile.show',[$request->user_id]);
    }

    public function movie(Request $request) {
    	return redirect()->route('movie.show',[$request->movie_id]);    	
    }
}
