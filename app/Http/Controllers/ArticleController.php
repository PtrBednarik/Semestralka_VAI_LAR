<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use App\Models\User;

class ArticleController extends Controller
{
    /**
     * Display a view for the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('articles_index');
    }

    /**
     * Return all resources
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $articles = array();

        //mozno by slo lepsie? priamo skratkou cez eloquent??
        foreach (Article::all() as $article) {
            $user = User::find($article->creator_id);
            if ($user){
                $article->user = $user;
            }
            array_push($articles,$article);
        }
        return response()->json($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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
            $article = new Article;
            $article->title = $request->title;
            $article->content = $request->content;
            $article['creator_id'] = auth()->user()->id;
            $article->save();
            //pridat este usera
            $user = User::find($article->creator_id);
            if ($user){
                $article->user = $user;
            }
            return response()->json(['success'=>'true', 'article' => $article]);
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article=Article::find($id);
        return view('article_detail')->with("article", $article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            $article = Article::find($id);
            $article->title = $request->title;
            $article->content = $request->content;
            $article['creator_id'] = auth()->user()->id;
            $article->save();
            return response()->json(['success'=>'true', 'article' => $article]);
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article=Article::find($id);
        return $article->delete(); //returns true/false
    }
}
