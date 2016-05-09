<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Collection;
use App\Comment;
use Redirect;
use Auth;
use Redis;

class CollectionController extends BaseController
{
    
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function show($id)
    {
        $collection = Collection::where('collections.id',$id)->with('movies')->first(); 
        $comments = Comment::join('users','users.id','=','comments.user_id')->where('collection_id','=',$id)
                    ->select('users.id','users.name','users.username', 'users.profile_picture', 'comments.comment', 'comments.created_at')->get();        
        return view('collections.show')->with(['collection' => $collection, 'comments' => $comments]);
    }

    public function create() 
    {
    	return view('collections.create');
    }

 	public function validator($data) 
 	{
 		return Validator::make($data, [
            'collection_name' => 'required|min:3',
            'collection_description' => 'min:0|:255'
        ]);
 	}
    
    public function store(Request $request) 
    {
    	$data = $request->only(['collection_name','collection_description','collection_modal']);
    	$validator = $this->validator($data);
    	if($validator->fails()) {               
            return Redirect::back()->withErrors($validator);            
    	} else {
    		$collection = new Collection;
    		$collection->user_id = Auth::user()->id;
    		$collection->name = $data['collection_name'];
    		$collection->description = $data['collection_description'];
    		$collection->save();
            return $data['collection_modal'] == 0 ? Redirect('profile') : Redirect::back(); 
    	}
    }

    public function edit($id) {
        $collection = Collection::find($id)->first();        
        return view('collections.edit')->with('collection',$collection);
    }

    public function update(Request $request, $id) {        
        $data = $request->only(['collection_name','collection_description']);
        $validator = $this->validator($data);
        if($validator->fails()) {               
            return Redirect::back()->withErrors($validator);            
        } else {
            Collection::where('id', $id)                
                ->update(['name' => $data['collection_name'],
                    'description'=>$data['collection_description']
                ]);        
            return redirect()->route('profile.index');
        }
    }

    public function destroy(Request $request) {    
        $collection = Collection::find($request->collection_id)->delete();        
        return redirect()->route('profile.index');
    }
}
