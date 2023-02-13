<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function index()
    {
        return view('gallery');
    }

    /**
     * Return all resources
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(Image::all());
    }

    public function show($year)
    {
        $images = Image::all()->where('year', '=', $year);
        return view('gallery')->with("images", $images);
    }

    public function patch(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'title.required' => 'Zadaj titulok.',
        ]);
        if ($validator->passes()) {
            $image = Image::find($id);
            $image->title = $request->title;
            $image->save();
            return response()->json(['success' => 'true', 'image' => $image]);
        }
        return response()->json(['error'=>$validator->errors()]);
    }
}
