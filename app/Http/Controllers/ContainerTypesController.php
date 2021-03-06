<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreContainerType;
use App\ContainerType;

class ContainerTypesController extends Controller
{
    public function index()
    {
        return view('admin/maintenance/container_type_index');
    }


    public function store(StoreContainerType $request)
    {

        $ct = ContainerType::create($request->all());
        return $ct;
    }

    public function update(StoreContainerType $request, $id)
    {
        $container_type = ContainerType::findOrFail($id);
        $container_type->description = $request->description;
        $container_type->save();

        return $container_type;
    }


    public function destroy($id)
    {
        $container_type = ContainerType::findOrFail($id);
        $container_type->delete();
    }

    public function reactivate(Request $request)
    {
        $container_type = ContainerType::withTrashed()
        ->where('id',$request->id)
        ->restore();
  
    }

    public function ct_utilities(){

        return view('admin/utilities.container_type_utility_index');
    }
}
