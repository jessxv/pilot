<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charge;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StoreCharge;
class ChargesController extends Controller
{

    public function index()
    {
        return view('admin/maintenance.charge_index');
    }


    public function store(StoreCharge $request)
    {

        $ch = Charge::create($request->all());
        return $ch;
    }

    public function update(StoreCharge $request, $id)
    {
        $charge = Charge::findOrFail($id);
        $charge->description = $request->description;
        $charge->save();

        return $charge;
    }


    public function destroy($id)
    {
        $charge = Charge::findOrFail($id);
        $charge->delete();

    }

    public function reactivate(Request $request)
    {
        $charge = Charge::withTrashed()
        ->where('id',$request->id)
        ->restore();
  
    }

    public function ch_utilities(){

        return view('admin/utilities.charge_utility_index');
    }
}
