<?php

namespace Modules\Retail\Http\Controllers\Customer;

use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Customer\Entities\CustomerInvoiceMaster;
use Modules\Master\Entities\PettyCashTransfer;
use Modules\Retail\Entities\CashDepositHistory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Modules\Corporate\Entities\CorporateProfile;

class CashTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if( !Session::has('retail')){
            return redirect(route('login')); 
        }
        $retail = Session::get('retail');
      
        $data['last_date'] = CustomerInvoiceMaster::where('payment_mode', 'Cash')
                                            ->where('payment_status', 1)
                                            ->where('retail_id', $retail->id)
                                            ->latest('updated_at')->first();
                                            
                                          
       $data['pending'] = CorporateProfile::where('id', $retail->id)->select('pending')->first();
       $cash = CustomerInvoiceMaster::where('payment_mode', 'Cash')
                                            ->where('payment_status', 0)
                                            ->where('retail_id', $retail->id)
                                            ->select(DB::raw('date , sum(grant_total) as total'))
                                            ->groupBy('date')
                                            ->get();
        $detail=[];                                     
        foreach($cash as $cash_detail){
          $d['date'] = $cash_detail->date;
          $d['total'] = $cash_detail->total;
          $d['check'] = false;
          array_push($detail, $d);
        }
         $data['cash'] = $detail;
        return view('retail::cash.transfer', $data);
    }

    public function cashTransfer(Request $request){

        $retail = Session::get('retail');
        $permission = 'Retail'.$retail->id.'.deposit.cash';
        if($request->user()->can($permission)){
        $data = json_decode($request->data, true);
        $input_deposit = (int)$data['deposit'];
        $sum = 0;
        foreach($data['cashData'] as  $num){
            if($num['check'] == true){
            $sum+= $num['total'];
            }
        }
        if($data['pendingCheck'] == true){
            $a = 0;
            $a = $sum + (int)$data['pending'];
            $pending_amount = $a  - (int)$input_deposit;
            CorporateProfile::where('id', $retail->id)->update(['pending' => $pending_amount]);
        }else{
            $pending_amount = $sum - (int)$input_deposit;
            $pen_amt = CorporateProfile::where('id', $retail->id)->first()->pending;
            CorporateProfile::where('id', $retail->id)->update(['pending' =>  (int)$pen_amt + $pending_amount]);
        }
        foreach($data['cashData'] as  $num){
            if($num['check'] == true){
            CustomerInvoiceMaster::where('date', $num['date'])->update(['payment_status'=>1]);

            }
        }
        $cash = new CashDepositHistory();
        $cash->cash_date =  now();
        $cash->deposit_amount =  (int)$input_deposit;
        $cash->retail_id = $retail->id;
        $cash->save();

        return redirect()->back();
    }else{
        abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
    }
    }

    public function depositHistory(Request $request){
      
        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.view.depositcashhistory';
        if($request->user()->can($permission)){
        return view('retail::cash.cashdeposit');
        }
        else{
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
    }

    public function depositHistoryListing(Request $request)
    { 
        $retail = Session::get('retail');
        if ($request->ajax()) {
            $data = CashDepositHistory::join('corporate_profiles', 'corporate_profiles.id', 'cash_deposit_history.retail_id')
            ->where('cash_deposit_history.retail_id', $retail->id)->select('cash_deposit_history.*', 'corporate_profiles.name as retail_name')->latest();
            return DataTables::of($data)
            ->addColumn('deposit_date', function($row){
                return Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d-m-Y');
            })
            ->addColumn('cash_date', function($row){
                return Carbon::parse($row->cash_date)->format('d-m-Y');
            })
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route("retailpetty.cash.edit") . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    // $actionBtn = $actionBtn.'<a href="' . route("picklist.generator", ["id" => $row->id]) . '"  class="edit btn btn-primary btn-sm">Picklist</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])

                ->make(true);
        }
    }
    


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('retail::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('retail::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('retail::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
