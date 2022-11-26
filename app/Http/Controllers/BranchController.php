<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\CarModel;
use App\Models\Color;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {

    }


    public function create()
    {
        $branches = Branch::get();
        $colors = Color::orderBy('name')->get();
        $models = CarModel::orderBy('name')->get();

        return view('branch.create', compact('branches', 'colors' , 'models'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $branch = Branch::create([
            'name' => $request->name,
        ]);

        $branches = Branch::get();
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
        $branch = Branch::find($id);
        $branch->name = $request->name;
        $branch->save();

         return redirect()->back();
    }


    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return back();
    }
}
