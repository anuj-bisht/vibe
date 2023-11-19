<?php

namespace Modules\Retail\Http\Controllers\Retail;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Modules\Master\Entities\Size;
use Modules\Retail\Entities\Grn;
use Modules\Retail\Entities\GrnMaster;
use Modules\Retail\Entities\GrnSubMaster;
use Yajra\DataTables\Facades\DataTables;

class GrnController extends Controller
{
    public function index()
    {
        $retail = Session::get('retail');
        $data['start_date']= Carbon::now()->startOfMonth()->toDateString();
        $data['end_date']= Carbon::now()->toDateString();
        return view('retail::grn.pending', $data);
    }



    public function validatedIndex()
    {
        $retail = Session::get('retail');
        return view('retail::grn.validated');
    }

   

    public function grnPendingListing(Request $request)
    {
        $retail = Session::get('retail');
        if ($request->ajax()) {
            $data = GrnMaster::leftjoin('corporate_profiles', 'corporate_profiles.id','=','grn_masters.retail_id')
            ->select('grn_masters.*','corporate_profiles.name as retailer_name')->where('grn_masters.retail_id', $retail->id);
            if(!empty($request->from_date)) {

                $data =  $data->whereBetween('grn_masters.created_at', array($request->from_date, Carbon::parse($request->to_date)->endOfDay()));

            } 
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('retailer.grn.view', ['id' => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';

                    return $actionBtn;
                })
                ->rawColumns(['view', 'action'])
                ->make(true);
        }
    }

    public function validatedGrnPendingListing(Request $request)
    {
        $retail = Session::get('retail');
        if ($request->ajax()) {
            $data = GrnMaster::with('corporate_profile')->where('retail_id',   $retail->id)->where('validated', 1)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('retailer.validatedgrn.view', ['id' => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';

                    return $actionBtn;
                })
                ->rawColumns(['view', 'action'])
                ->make(true);
        }
    }


    public function create(Request $request)
    {
        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.grn.create';
        if($request->user()->can($permission)){
        $number = GrnMaster::select('grn_no')->get()->last();
        $data['grnNumber'] = $number ? $number->grn_no + 1 : 1;
        $data['sizes'] = Size::all();
        return view('retail::grn.createGrn', $data);
        }else{
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');

        }
    }

    public function moveToGrn(Request $request)
    {
        $data = json_decode($request->data, true);
        $retail = Session::get('retail');

        $grn_master = new GrnMaster();
        $grn_master->grn_no = $data['grnNumber'];
        $grn_master->retail_id = $retail->id;
        $grn_master->validated = 0;
        $grn_master->save();

        foreach ($data['child'] as $detail) {

            $grn_sub_master = new GrnSubMaster();
            $grn_sub_master->grn_master_id = $grn_master->id;
            $grn_sub_master->color_id = $detail['color_id'];
            $grn_sub_master->product_id = $detail['product_id'];
            $grn_sub_master->per_qty = $detail['per_qty'];
            $grn_sub_master->total_qty = $detail['totalq'];
            $grn_sub_master->total_price = $detail['total_price'];
            $grn_sub_master->save();

            foreach ($detail['cs'] as $key => $val) {
                $grn = new Grn();
                $grn->grn_sub_master_id = $grn_sub_master->id;
                $grn->size_id = $key;
                $grn->qty = $val;
                $grn->save();
            }
        }
        session()->flash('message', 'Grn Create Successfully.');
        return redirect(route('retail.pending.grn'));
    }




    public function view(Request $request)
    {
        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.grn.pending.view';
        if($request->user()->can($permission)){
        $id = $request->id;
        $data['sizes'] = Size::get();
        $data['grn_detail'] = GrnMaster::with(['corporate_profile', 'detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->where('validated', 0)->first();
        return view('retail::grn.pendinggrn', $data);
    }else{
        abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
    }
    }
    public function  Validatedview(Request $request){
        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.grn.validate.view';
        if($request->user()->can($permission)){
        $id = $request->id;
        $data['sizes'] = Size::get();
        $data['grn_detail'] = GrnMaster::with(['corporate_profile', 'detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->where('validated', 1)->first();

        return view('retail::grn.validatedgrn', $data);
    }else{
        abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
    }
    }
}
