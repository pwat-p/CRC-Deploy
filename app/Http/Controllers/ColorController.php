<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {

    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $color = Color::create([
            'name' => $request->name,
        ]);

        return redirect()->back();

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $color = Color::find($id);
        $color->name = $request->name;
        $color->save();

        return redirect()->back();
    }


    public function destroy($id)
    {
        $color = Color::find($id);
        $color->delete();
        return back();
    }
}
