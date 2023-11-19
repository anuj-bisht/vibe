<?php

namespace Modules\Customer\Http\Controllers\Customer;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Corporate\Entities\City;
use Modules\Corporate\Entities\Country;
use Modules\Corporate\Entities\State;
use Modules\Customer\Entities\Customer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        

        return view('customer::customer.index');
    }

        public function customerListing(Request $request) {
            if ($request->ajax()) {
                $data = Customer::query();
                return Datatables::of($data)
                    ->addColumn('action', function($row){
                        $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('customer.edit',['id'=>$row]). '"  type="submit"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg></a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        } 
    }

    public function create()
    {
        $data['country'] = Country::all();

        return view('customer::customer.create', $data);
    }

    public function retailCreate(Request $request)
    {
        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.retailer.create.customer';
        if($request->user()->can($permission)){
        $data['country'] = Country::all();
        return view('customer::customer.rcreate', $data);
        }
        else{
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
    }

    public function store(Request $request)
    {
      
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required',
            'alter_no'=>'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required'
        ]);

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        $customer->alter_no = $request->alter_no;
        $customer->country_id = $request->country;
        $customer->state_id = $request->state;
        $customer->city_id = $request->city;
        $customer->age = $request->age ?? '';
        $customer->gender = $request->gender ?? '';
        $customer->dob = $request->dob ?  $request->dob : null ;
        $customer->aniversary_date= $request->aniversary_date ? $request->aniversary_date : null;
        $customer->save();
            
    if($request->modal == 1){
        return redirect()->back();
    }elseif($request->modal == 2){
        return redirect(route('retailcustomer.invoiceList'));
    }
   
    else{
        return redirect(route('customer.index'));

    }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('customer::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data['country']= Country::all();
        $data['state']= State::all();
        $data['city']= City::all();

        $data['customer']= Customer::with(['country', 'state','city'])->where('id', $id)->first();

        // return $data['customer'];
        // die;
    
        
        return view('customer::customer.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required',
            'alter_no'=>'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required'
        ]);
       Customer::where('id', $id)->update([
        'name'=>$request->name,
        'email'=>$request->email,
        'mobile'=>$request->mobile,
        'alter_no'=>$request->alter_no,
        'country_id'=>$request->country,
        'state_id'=>$request->state,
        'city_id'=>$request->city,
        'age'=>$request->age ?? "nil",
            'gender'=>$request->gender ?? "nil",
            'dob'=>$request->dob ?? null,
            'aniversary_date'=>$request->aniversary_date ?? null,
       ]);
       return redirect(route('customer.index'));

    }

   
}
