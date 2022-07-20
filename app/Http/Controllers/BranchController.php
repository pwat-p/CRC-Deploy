<?php

namespace App\Http\Controllers;

use App\Models\Branch;
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
        return view('branch.create', compact('branches'));
    }


    public function store(Request $request)
    {
        // return $request;
        $branch = Branch::create([
            'name' => $request->name,
        ]);
        
        $branches = Branch::get();
        return view('branch.create', compact('branches'));
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
        //
    }


    public function destroy($id)
    {
        //
    }
}
