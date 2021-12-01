<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\HISTORY;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    //

    public function index(Request $request)
    {
        $request = HISTORY::all();
        return $request;
    }

    public function store(Request $request, History $history)
    {
        $validation = Validator::make(
            $request->all(),

            [
                'title' => "required",
                'content' => "required",
                'image'=> "required"
            ]
        );
        if ($validation->fails()) {
            return response($validation->errors());
        }

        if ($request->hasfile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('history', $imageName);

            $history->image = $imageName;
        }

        $history->title = $request->title;
        $history->content = $request->content;
        $history->save();

        return response(
            [
                'content' => HISTORY::get(),
                'message' => "data added successfully"
            ],
            200
        );
    }

    public function update(Request $request, History $history)
    {
        $validation = Validator::make($request->all(), [
            'title' => "nullable",
            'content' => "required",
            'image' => "nullable"
        ]);
        if ($validation->fails()) {
            return response($validation->errors());
        }

        if ($request->hasfile('image')) {

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('history', $imageName);

            $history->image = $imageName;
        }

        $history->title = $request->title;
        $history->content = $request->content;
        $history->save();

        return response(
            [
                'updated' => HISTORY::get(),
                'message' => "data updated successfully"
            ],
            200
        );
    }
}
