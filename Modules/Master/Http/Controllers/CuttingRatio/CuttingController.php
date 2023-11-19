<?php

namespace Modules\Master\Http\Controllers\CuttingRatio;

use Illuminate\Http\Request;
use Modules\Master\Entities\Size;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Support\Renderable;
use Modules\Master\Entities\Cutting;
use Modules\Master\Entities\CuttingRatio;

class CuttingController extends Controller
{

    public function index()
    {
        $data['cutting'] = Cutting::all();
        return view('master::cutting.index', $data);
    }


    public function create()
    {
        $data['sizes'] = Size::all();
        return view('master::cutting.create', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'sum' => 'required|gte:100|lte:100',
            'name'=>'required|unique:cuttings,name'
        ]);

        $sizes = Size::all();
        $cutting = new Cutting();
        $cutting->name = $request->name;
        $cutting->save();
        $amount = 0;
        $ratios = $request->cutting_ratios;
        foreach ($sizes as $size) {
            if ($ratios[$size->id] != null) {
                $cuttingR = new CuttingRatio();
                $cuttingR->cutting_id = $cutting->id;
                $cuttingR->size_id = $size->id;
                $cuttingR->ratio = $ratios[$size->id];
                $cuttingR->save();
                $amount += $ratios[$size->id];
            }
        }
        session()->flash('message', 'Cutting Ratio Create Successfully.');
        return redirect(route('master.cutting'));
    }

    public function edit($id)
    {
        $data['sizes'] = Size::all();
        $data['ratios'] = Cutting::with(['child'])->find($id);
        return view('master::cutting.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'sum' => 'required|gte:100|lte:100'
        ]);
        CuttingRatio::where('cutting_id', $id)->delete();
        $sizes = Size::all();
        $cutting = Cutting::find($id);
        $cutting->name = $request->name;
        $cutting->save();
        $amount = 0;
        $ratios = $request->cutting_ratios;

        foreach ($sizes as $size) {
            if ($ratios[$size->id] != null) {

                $cuttingR = new CuttingRatio();
                $cuttingR->cutting_id = $cutting->id;
                $cuttingR->size_id = $size->id;
                $cuttingR->ratio = $ratios[$size->id];
                $cuttingR->save();
                $amount += $ratios[$size->id];
            }
        }
        $ratios = $request->cutting_ratios;
        session()->flash('message', 'Cutting Ratio Update Successfully.');
        return redirect(route('master.cutting'));
    }
}
