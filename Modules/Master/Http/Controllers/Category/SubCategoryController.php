<?php

namespace Modules\Master\Http\Controllers\Category;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Category;
use Modules\Master\Entities\SubCategory;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $subcategory['data'] = SubCategory::with('parent')->get();

        return view('master::subcategory.index', $subcategory);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data['subcategory'] = Category::all();

        return view('master::subcategory.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate(
            ['subcategory_name'=>'required',
            'parent_id'=>'required']

           );
        $subcategory= new SubCategory();
        $subcategory->name=$request->subcategory_name;
        $subcategory->category_id=$request->parent_id;
        $subcategory->save();
        $request->session()->flash('message','Sub Category Added Successfully');
        return redirect(route('master.subcategory'));
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
        $data['category'] = Category::all();
        $data['subcategory']= SubCategory::with('parent')->where('id',$id)->first();

        return view('master::subcategory.edit', $data);

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
            ['subcategory_name'=>'required',
            'parent_id'=>'required']

           );
        $category= SubCategory::where('id',$id)->update([
            'name'=>$request->subcategory_name,
            'category_id'=>$request->parent_id
      ]);
      $request->session()->flash('message','Sub Category Updated Successfully');

      return redirect(route('master.subcategory'));


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
