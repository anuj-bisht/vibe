<?php

namespace Modules\Master\Http\Controllers\Petty;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Retail\Entities\CashDepositHistory;
use Yajra\DataTables\Facades\DataTables;

class CashTransferController extends Controller
{
    public function index(Request $request)
    {
        $data['retail'] = CorporateProfile::where('is_retail', 1)->get();
        return view('master::cash.index', $data);
    }

    public function cashTransferHistoryListing(Request $request)
    {
        if ($request->ajax()) {
            $data = CashDepositHistory::join('corporate_profiles', 'corporate_profiles.id', 'cash_deposit_history.retail_id')->select('cash_deposit_history.*', 'corporate_profiles.name as retail_name')->latest();
            if(!empty($request->from_date) && $request->retail_id == 0) {
                $data =  $data->whereBetween('cash_deposit_history.created_at', array($request->from_date, Carbon::parse($request->to_date)->endOfDay()));
            }
            if(!empty($request->from_date) && $request->retail_id != 0) {
                $data =  $data->where('cash_deposit_history.retail_id', $request->retail_id)->whereBetween('cash_deposit_history.created_at', array($request->from_date, Carbon::parse($request->to_date)->endOfDay()));
            }
            return DataTables::of($data)
                ->addColumn('retail', function ($row) {
                    return $row->retail_name;
                })
                ->filter(function ($query) {
                    if (request()->search['value']) {
                        $query->where('corporate_profiles.name', 'like', "%" . request()->search['value'] . "%");
                    }
                 
                })
            
                        
                ->addColumn('deposit_date', function ($row) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d-m-Y');
                })
                
              
                ->addColumn('cash_date', function ($row) {
                    return Carbon::parse($row->cash_date)->format('d-m-Y');
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route("retailpetty.cash.edit") . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])

                ->make(true);
        }
    }
}
