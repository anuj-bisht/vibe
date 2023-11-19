<?php

namespace Modules\Master\Http\Controllers\Category;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\SubCategory;
use Modules\Master\Entities\SubSubCategory;

class SubSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $subsubcategory['data'] = SubSubCategory::with('parent')->get();
        return view('master::subsubcategory.index', $subsubcategory);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data['subsubcategory'] = SubCategory::all();

        return view('master::subsubcategory.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $request->validate(
            ['subsubcategory_name'=>'required',
            'parent_id'=>'required']

           );
        $subsubcategory= new SubSubCategory();
        $subsubcategory->name=$request->subsubcategory_name;
        $subsubcategory->sub_category_id=$request->parent_id;
        $subsubcategory->save();
        $request->session()->flash('message','Sub  Sub Category Added Successfully');

        return redirect(route('master.subsubcategory'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('master::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data['subcategory'] = SubCategory::all();
        $data['subsubcategory']=SubSubCategory::with('parent')->where('id',$id)->first();

        return view('master::subsubcategory.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            ['subsubcategory_name'=>'required',
            'parent_id'=>'required']

           );
        $category= SubSubCategory::where('id',$id)->update([
            'name'=>$request->subsubcategory_name,
            'sub_category_id'=>$request->parent_id
      ]);
      $request->session()->flash('message','Sub  Sub Category Updated Successfully');

      return redirect(route('master.subsubcategory'));


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
