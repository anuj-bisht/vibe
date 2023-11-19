<?php

namespace Modules\Corporate\Http\Controllers\Corporate;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Master\Entities\Crm;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Agent;
use Modules\Master\Entities\Discount;
use Modules\Master\Entities\Transport;
use Modules\Master\Entities\Commission;
use Illuminate\Contracts\Support\Renderable;
use Modules\Corporate\Entities\City;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Corporate\Entities\Country;
use Modules\Corporate\Entities\State;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Modules\Product\Entities\Product;
use Yajra\DataTables\Facades\DataTables;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    
        $data['states']=State::all();
        return view('corporate::corporate.index', $data);
    }

   
    public function clientListing(Request $request){
        if ($request->ajax()) {
            $data =CorporateProfile::join('states','states.id', '=','corporate_profiles.bstate_id')->select('corporate_profiles.*', 'states.name as billing_state_name');

            if(!empty($request->state_id)) {
                $data =  $data->where('corporate_profiles.bstate_id', $request->state_id);            
            }
           
            return Datatables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route("corporate.edit", ["id" => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    return $actionBtn;
                })
                ->filter(function ($query) {
                    if (request()->search['value']) {
                        $query->where('corporate_profiles.name', 'like', "%" . request()->search['value'] . "%");
                    }
                })
                
                ->rawColumns(['action'])
                ->make(true);

        }

    }

    public function create()
    {
        $data['discount']=Discount::all();
        $data['crm']=Crm::all();
        $data['commission']=Commission::all();
        $data['agent']=Agent::all();
     
        $data['transport']=Transport::all();
        $data['country']=Country::all();
        $data['dcountry']=Country::all();
        return view('corporate::corporate.create',$data);

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        
         $request->validate([
            'name'=>'required',
            'is_retail'=>'required',
            'contact_person_1'=>'required',
            'designation_1'=>'required',
            'mobile_number_1'=>'required',
            'email_id_1'=>'required',
            'billing_address'=>'required',
            'delivery_address'=>'required',
            'billing_zip_code'=>'required',
            'delivery_zip_code'=>'required',
            'billing_country'=>'required',
            'delivery_country'=>'required',
            'billing_state'=>'required',
            'delivery_state'=>'required',
            'billing_city'=>'required',
            'delivery_city'=>'required',
            'gst_number'=>'required',
            'marginA'=>'required',
            'marginB'=>'required',
            'marginC'=>'required',
            'marginD'=>'required',
            'commission_id'=>'required',
            'status'=>'required'
        ]);
       
       $corporate = new CorporateProfile();
       $corporate->cash_deliver = $request->cashdays ?? '';
       $corporate->is_retail = $request->is_retail;
       $corporate->name = $request->name;
       $corporate->contact_person_1 = $request->contact_person_1;
       $corporate->designation_1= $request->designation_1;
       $corporate->mobile_no_1= $request->mobile_number_1;
       $corporate->email_id_1=$request->email_id_1;
       $corporate->contact_person_2= $request->contact_person_2 ? $request->contact_person_2 : "";
       $corporate->designation_2= $request->designation_2 ? $request->designation_2 : "";
       $corporate->mobile_no_2= $request->mobile_number_2 ? $request->mobile_number_2 : "";
       $corporate->email_id_2= $request->email_id_2 ? $request->email_id_2  : "";
       $corporate->contact_person_3=$request->contact_person_3 ? $request->contact_person_3 : "";
       $corporate->designation_3= $request->designation_3 ? $request->designation_3: "";
       $corporate->mobile_no_3= $request->mobile_number_3 ? $request->mobile_number_3  : "";
       $corporate->email_id_3= $request->email_id_2 ? $request->email_id_2 : "";
       $corporate->billing_address=$request->billing_address;
       $corporate->billing_zip_code=$request->billing_zip_code;
       $corporate->bcountry_id=$request->billing_country;
       $corporate->bstate_id=$request->billing_state;
       $corporate->bcity_id=$request->billing_city;
       $corporate->delivery_address=$request->delivery_address;
       $corporate->delivery_zip_code=$request->delivery_zip_code;
       $corporate->dcountry_id=$request->delivery_country;
       $corporate->dstate_id=$request->delivery_state;
       $corporate->dcity_id=$request->delivery_city;
       $corporate->gst_no=$request->gst_number;
       $corporate->credit_days=$request->credit_days ? $request->credit_days : "";
       $corporate->credit_limit=$request->credit_limit ? $request->credit_limit : "";
       $corporate->discount_id=$request->discount_id ? $request->discount_id : null;
       $corporate->crm_id=$request->crm_id ? $request->crm_id : null;
       $corporate->commission_id=$request->commission_id;
       $corporate->agent_id=$request->agent_id ? $request->agent_id : null;
       $corporate->transport_id=$request->transport_id ? $request->transport_id : null;
       $corporate->communication_via=$request->communication ? $request->communication : "";
       $corporate->client_charge=$request->charge ? $request->charge : "";
       $corporate->status=$request->status;
       $corporate->A = $request->marginA ? $request->marginA : null;
       $corporate->B = $request->marginB ? $request->marginB : null;
       $corporate->C = $request->marginC ? $request->marginC : null;
       $corporate->D = $request->marginD ? $request->marginD : null;
       $corporate->save();
        if($request->is_retail == 1){
            $permissions = Permission::whereBetween('id', [80,99])->get();       
            foreach($permissions as $permission){
                Permission::insert([
                    'name'=>'Retail'.$corporate->id.'.'.$permission['name'],
                    'lang_en'=>'Retail'.$corporate->id.' '.$permission['lang_en'],
                    'guard_name' =>'web',
                    'module_name'=>$corporate->name,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
            ]);
            }
            Artisan::call('cache:clear');
        }


       session()->flash('message', 'Client Add Successfully.');
       return redirect(route('corporate.index'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('corporate::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

        $data['discount']=Discount::all();
        $data['crm']=Crm::all();
        $data['commission']=Commission::all();
        $data['agent']=Agent::all();
        $data['transport']=Transport::all();
        $data['country']=Country::all();
        $data['dcountry']=Country::all();
        $data['corporate']=CorporateProfile::with('delivery_citys','billing_citys','delivery_states','billing_states')->find($id);
        // return  $data['corporate'];
        // die;
        return view('corporate::corporate.edit', $data);
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
            'is_retail'=>'required', 
            'contact_person_1'=>'required',
            // 'contact_person_2'=>'required',
            // 'contact_person_3'=>'required',
            'designation_1'=>'required',
            // 'designation_2'=>'required',
            // 'designation_3'=>'required',
            'mobile_number_1'=>'required',
            // 'mobile_number_2'=>'required',
            // 'mobile_number_3'=>'required',
            'email_id_1'=>'required',
            // 'email_id_2'=>'required',
            // 'email_id_3'=>'required',
            'billing_address'=>'required',
            'delivery_address'=>'required',
            'billing_zip_code'=>'required',
            'delivery_zip_code'=>'required',
            'billing_country'=>'required',
            'delivery_country'=>'required',
            'billing_state'=>'required',
            'delivery_state'=>'required',
            'billing_city'=>'required',
            'delivery_city'=>'required',
            'gst_number'=>'required',
            'marginA'=>'required',
            'marginB'=>'required',
            'marginC'=>'required',
            'marginD'=>'required',
            // 'credit_days'=>'required',
            // 'credit_limit'=>'required',
            // 'discount_id'=>'required',
            // 'crm_id'=>'required',
            'commission_id'=>'required',
            // 'agent_id'=>'required',
            // 'transport_id'=>'required',
            // 'charge'=>'required',
            'status'=>'required'
        ]);
        $corporate = CorporateProfile::find($id);
        $corporate->is_retail = $request->is_retail;
        $corporate->cash_deliver = $request->cashdays ?? '';
        $corporate->name = $request->name;
        $corporate->contact_person_1 = $request->contact_person_1;
        $corporate->designation_1= $request->designation_1;
        $corporate->mobile_no_1= $request->mobile_number_1;
        $corporate->email_id_1=$request->email_id_1;
        $corporate->contact_person_2= $request->contact_person_2 ? $request->contact_person_2 : "";
        $corporate->designation_2= $request->designation_2 ? $request->designation_2 : "";
        $corporate->mobile_no_2= $request->mobile_number_2 ? $request->mobile_number_2 : "";
        $corporate->email_id_2= $request->email_id_2 ? $request->email_id_2  : "";
        $corporate->contact_person_3=$request->contact_person_3 ? $request->contact_person_3 : "";
        $corporate->designation_3= $request->designation_3 ? $request->designation_3: "";
        $corporate->mobile_no_3= $request->mobile_number_3 ? $request->mobile_number_3  : "";
        $corporate->email_id_3= $request->email_id_2 ? $request->email_id_2 : "";
        $corporate->billing_address=$request->billing_address;
        $corporate->billing_zip_code=$request->billing_zip_code;
        $corporate->bcountry_id=$request->billing_country;
        $corporate->bstate_id=$request->billing_state;
        $corporate->bcity_id=$request->billing_city;
        $corporate->delivery_address=$request->delivery_address;
        $corporate->delivery_zip_code=$request->delivery_zip_code;
        $corporate->dcountry_id=$request->delivery_country;
        $corporate->dstate_id=$request->delivery_state;
        $corporate->dcity_id=$request->delivery_city;
        $corporate->gst_no=$request->gst_number;
        $corporate->credit_days=$request->credit_days ? $request->credit_days : "";
        $corporate->credit_limit=$request->credit_limit ? $request->credit_limit : "";
        $corporate->discount_id=$request->discount_id ? $request->discount_id : null;
        $corporate->crm_id=$request->crm_id ? $request->crm_id : null;
        $corporate->commission_id=$request->commission_id;
        $corporate->agent_id=$request->agent_id ? $request->agent_id : null;
        $corporate->transport_id=$request->transport_id ? $request->transport_id : null;
        $corporate->communication_via=$request->communication ? $request->communication : "";
        $corporate->client_charge=$request->charge ? $request->charge : "";
        $corporate->status=$request->status;
        $corporate->A = $request->marginA ? $request->marginA : null;
        $corporate->B = $request->marginB ? $request->marginB : null;
        $corporate->C = $request->marginC ? $request->marginC : null;
        $corporate->D = $request->marginD ? $request->marginD : null;
        $corporate->save();
        session()->flash('message', 'Client Detail Update Successfully.');
        return redirect(route('corporate.index'));
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
