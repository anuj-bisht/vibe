<?php

namespace Modules\Master\Http\Controllers\Category;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Category;
use Modules\Master\Entities\MainCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $main_category['data'] = MainCategory::all();

   return view('master::maincategory.index', $main_category);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $main_category['data'] = MainCategory::all();
        return view('master::maincategory.create', $main_category);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       $request->validate(
        ['main_category_name'=>'required']

       );

        $main_category_name= new MainCategory();
        $main_category_name->name=$request->main_category_name;
        $main_category_name->save();
        $request->session()->flash('message','Main Category Added Successfully');

        return redirect(route('master.maincategory'));


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id){
        $data['main_category']= MainCategory::where('id', $id)->first();


        return view('master::maincategory.edit', $data);
    }


    public function categoryIndex()
    {
        $category['data'] = Category::with('parent')->get();


        return view('master::category.index', $category);
    }
    public function categoryCreate()
    {
        $data['main_category'] = MainCategory::all();
        return view('master::category.create', $data);
    }

    public function categoryStore(Request $request)
    {
        $request->validate(
            ['category_name'=>'required',
            'parent_id'=>'required']

           );
        $category_name= new Category();
        $category_name->name=$request->category_name;
        $category_name->main_category=$request->parent_id;
        $category_name->save();
        $request->session()->flash('message','Category Added Successfully');
        return redirect(route('master.category'));


    }
     public function categoryEdit(Request $request, $id)
    {
        $data['main_category'] = MainCategory::all();
        $data['category']= Category::with('parent')->where('id',$id)->first();
        return view('master::category.edit', $data);
    }

    public function categoryUpdate(Request $request, $id)
    {
        $request->validate(
            ['category_name'=>'required',
            'parent_id'=>'required']
           );

        $category= Category::where('id',$id)->update([
              'name'=>$request->category_name,
              'main_category'=>$request->parent_id
        ]);
        $request->session()->flash('message','Category Updated Successfully');
        return redirect(route('master.category'));

    }
    public function show($id)
    {
        return view('master::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
  
        $request->validate(
            ['category_name'=>'required',
            ]

           );
        $category= MainCategory::where('id',$id)->update([
            'name'=>$request->category_name
      ]);
      $request->session()->flash('message','Main Category Updated Successfully');
      return redirect(route('master.maincategory'));
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
