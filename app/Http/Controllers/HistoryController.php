<?php

namespace App\Http\Controllers;

use App\Models\Event;

class HistoryController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('history')->with("events", $events);
    }
}
