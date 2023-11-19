<?php

namespace Modules\Master\Http\Controllers\Petty;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Master\Entities\PettyCashTransfer;
use Modules\Master\Entities\Wallet;
use Modules\Master\Entities\WalletHistoryLog;
use Yajra\DataTables\Facades\DataTables;


class PettyCashController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('master::petty.index');
    }

    public function cashListing(Request $request)
    {
        if ($request->ajax()) {
            // $data =PettyCashTransfer::leftjoin('corporate_profiles', 'corporate_profiles.id','=','petty_cash_transfers.retail_id')
            // ->select('petty_cash_transfers.*','corporate_profiles.name as corporate_name')->get();
            $data = CorporateProfile::where('is_retail', 1)->get();
            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route("petty.cash.create", ["id" => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></a>';
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
    public function create(Request $request)
    {
        // $data['pettycash'] = PettyCashTransfer::with('corporate_profile')->where('id', $request->id)->first();
        $data['wallet'] = Wallet::with('retail')->where('retail_id',  $request->id)->first();

        $data['retailer'] = CorporateProfile::where('is_retail', 1)->where('id', $request->id)->select('id', 'name')->first();
        return view('master::petty.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $request->validate([
            'retail_id' => 'unique:petty_cash_transfers,retail_id',
            'amount' => 'required'
        ]);
        $is_retail_exist = PettyCashTransfer::where('retail_id', $request->ret_id)->first();


        if ($file1 = $request->file('pettydoc')) {
            $doc = time() . rand(1, 100) . '.' . $file1->getClientOriginalName();
            $file1->move('pettycashdoc', $doc);
        } else {
            $doc = '';
        }

        if (isset($is_retail_exist)) {

            // $prev = PettyCashTransfer::where('id',$request->id)->first();
            $last_amount = WalletHistoryLog::where('retail_id', $request->ret_id)->latest('id')->first()->new_amount;

            if ($request->status == 'Credited') {

                $log =  new WalletHistoryLog();
                $log->validated = 0;
                $log->user_id = auth()->user()->id;
                $log->ret_id = null;
                $log->retail_id = $request->ret_id;
                $log->old_amount = $last_amount;
                $log->new_amount = (int)$request->amount +  $last_amount;
                $log->type = $request->status;
                $log->diff = (int)$request->amount;
                $log->doc = $doc;
                $log->save();
            }
        } else {
            $cash = new PettyCashTransfer();
            $cash->user_id = auth()->user()->id;
            $cash->retail_id = $request->ret_id;
            $cash->amount = (int)$request->amount;
            $cash->type = $request->status;
            $cash->date = $request->date;
            $cash->note = $request->note ?? "";
            if ($cash->save()) {
                $log =  new WalletHistoryLog();
                $log->validated = 0;
                $log->user_id = auth()->user()->id;
                $log->ret_id = null;
                $log->retail_id = $request->ret_id;
                $log->old_amount = 0;
                $log->new_amount = (int)$request->amount;
                $log->type = $request->status;
                $log->diff = (int)$request->amount;
                $log->doc = "";
                $log->save();
            }
            //   Wallet::insert([
            //     'retail_id'=>$request->ret_id,
            //     'wallet'=>(int)$request->amount
            //   ]);
        }

        return redirect(route('petty.index'));
    }

    public function show($id)
    {
        return view('master::show');
    }

    public function edit(Request $request)
    {
        $data['retailer'] = CorporateProfile::where('is_retail', 1)->select('id', 'name')->get();
        $data['pettycash'] = PettyCashTransfer::with('corporate_profile')->where('id', $request->id)->first();
        $data['last_detail'] = Wallet::with('retail')->where('retail_id',  $data['pettycash']->retail_id)->first();


        return view('master::petty.edit', $data);
    }

    public function update(Request $request)
    {
        if ($file1 = $request->file('pettydoc')) {
            $doc = time() . rand(1, 100) . '.' . $file1->getClientOriginalName();
            $file1->move('pettycashdoc', $doc);
        } else {
            $doc = '';
        }
        $prev = PettyCashTransfer::where('id', $request->id)->first();
        $last_amount = WalletHistoryLog::where('retail_id', $request->retail_id)->latest('id')->first()->new_amount;
        if (!isset($last_amount)) {
            $last_amount = 0;
        }

        if ($request->status == 'Credited') {

            $log =  new WalletHistoryLog();
            $log->validated = 0;
            $log->user_id = auth()->user()->id;
            $log->ret_id = null;
            $log->retail_id = $request->retail_id;
            $log->old_amount = $last_amount;
            $log->new_amount = (int)$request->amount +  $last_amount;
            $log->type = $request->status;
            $log->diff = (int)$request->amount;
            $log->doc = $doc;
            $log->petty_head_id = null;
            $log->save();
        }

        return redirect(route('petty.index'));
    }
    public function transactionHistory(Request $request)
    {
        $data['retail_id'] = $request->retail_id;
        return view('master::petty.history', $data);
    }

    public function transactionListing(Request $request)
    {
        if ($request->ajax()) {
            $data = WalletHistoryLog::leftjoin('users', 'users.id', '=', 'wallet_history_logs.user_id')
                ->leftjoin('corporate_profiles', 'corporate_profiles.id', '=', 'wallet_history_logs.retail_id')
                ->leftjoin('petty_heads', 'petty_heads.id', '=', 'wallet_history_logs.petty_head_id')
                ->where('wallet_history_logs.retail_id', $request->retail_id)->select('wallet_history_logs.*', 'users.name as username', 'corporate_profiles.name as retail_name', 'petty_heads.petty_heads as reason')->orderBy('wallet_history_logs.created_at', 'DESC');
            return DataTables::of($data->get())
                ->addColumn('action_by', function ($data) {
                    if ($data->username == null) {
                        return $data->retail_name;
                    } else {
                        return $data->username;
                    }
                })
                ->addColumn('doc', function ($data) {
                    if ($data->doc == '') {
                        return null;
                    } else {
                        $docBtn =   '<a class="btn btn-sm"  href="' . url('pettycashdoc/' . $data->doc) . '" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="8 12 12 16 16 12"></polyline><line x1="12" y1="8" x2="12" y2="16"></line></svg></a>';
                        return $docBtn;
                    }
                })
                ->addColumn('date', function ($data) {
                    return Carbon::parse($data->created_at)->format('d-m-Y');
                })
                ->addColumn('amount', function ($data) {
                    return $data->diff;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route("retailpetty.cash.edit") . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    // $actionBtn = $actionBtn.'<a href="' . route("picklist.generator", ["id" => $row->id]) . '"  class="edit btn btn-primary btn-sm">Picklist</a>';
                    return $actionBtn;
                })
                ->addColumn('reason', function ($row) {
                    return $row->reason ? $row->reason : '';
                })
                ->rawColumns(['doc'])

                ->make(true);
        }
    }
}
