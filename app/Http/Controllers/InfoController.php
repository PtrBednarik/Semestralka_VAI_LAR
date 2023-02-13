<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Adminposts;

class InfoController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('info_index');
        }
        return redirect()->route('user_login')->with('errmessage', 'Prosím prihlás sa.');
    }

    public function all()
    {
        return response()->json(Adminposts::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ], [
            'title.required' => 'Zadaj titulok.',
            'content.required' => 'Zadaj obsah.'
        ]);

        if ($validator->passes()) {
            $post = new Adminposts;
            $post->title = $request->title;
            $post->content = $request->content;
            $post->save();
            return response()->json(['success'=>'true', 'post' => $post]);
        }
        return response()->json(['error'=>$validator->errors()]);
    }

    public function show($id)
    {
        $post=Adminposts::find($id);
        return view('info_detail')->with("post", $post);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ], [
            'title.required' => 'Zadaj titulok.',
            'content.required' => 'Zadaj obsah.'
        ]);

        if ($validator->passes()) {
            $post = Adminposts::find($id);
            $post->title = $request->title;
            $post->content = $request->content;
            $post->save();
            return response()->json(['success'=>'true', 'post' => $post]);
        }
        return response()->json(['error'=>$validator->errors()]);
    }

    public function destroy($id)
    {
        $post=Adminposts::find($id);
        return $post->delete(); //returns true/false
    }
}
