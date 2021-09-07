<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;

class SubCategoriesController extends Controller
{
    //
    public function index()
    {
        $categories = Category::child()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);

        return view('dashboard.subcategories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::parent()->orderBy('id','DESC')->get();
        return view('dashboard.subcategories.create',compact('categories'));
    }


    public function store(SubCategoryRequest $request)
    {

        try {

            DB::beginTransaction();

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            $category = Category::create($request->except('_token'));

            //save translation
            //field 'name' in table 'category_translations'
            $category->name = $request->name;

            $category->save();

            DB::commit();
            return redirect()->route('admin.subcategories')->with(['success' => 'تم الحفظ بنجاح']);
            

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function edit($id)
    {
        //get specific categories and its translations
        $category = Category::find($id);

        if (!$category)
            return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

            $categories = Category::parent()->orderBy('id','DESC')->get();

        return view('dashboard.subcategories.edit', compact('category','categories'));
    }


    public function update($id, SubCategoryRequest $request)
    {


        try {
            $category=Category::find($id);

            if(!$category)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود']);    

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            $category -> update($request->all());

            //save translation
            //field 'name' in table 'category_translations'
            $category->name = $request->name;

            $category->save();



            return redirect()->route('admin.subcategories')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {

            $category = Category::find($id);
            if (!$category)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);


            $category->delete();
            return redirect()->route('admin.subcategories')->with(['success' => 'تم حذف القسم بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}
