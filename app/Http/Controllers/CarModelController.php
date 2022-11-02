<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;

class CarModelController extends Controller
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
        $path = null;
        if($request->file())
        {
            $filename = str_replace(" ", "_", $request->name) . "." . $request->file('model_image')->extension();
            $path = $this->uploadFile($filename, $request->file('model_image'), "model_image");
        }
        $carmodel = CarModel::create([
            'name' => $request->name,
            'model_image' => $path,
        ]);
        return back();
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


        $carModel = CarModel::find($id);
        $carModel->name = $request->name;

        $path = null;
        if($request->file())
        {
            $filename = str_replace(" ", "_", $request->name) . "." . $request->file('model_image')->extension();
            $path = $this->uploadFile($filename, $request->file('model_image'), "model_image");
        }
        $carModel->model_image = $path;

        $carModel->save();

    }


    public function destroy($id)
    {
        $carModel = CarModel::find($id);
        $carModel->delete();
        return back();
    }

    protected function uploadFile($filename, $file, $dir): string
    {
        $file->storeAs("public/{$dir}", $filename);
        return "/storage/{$dir}/{$filename}";
    }
}
