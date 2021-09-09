<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;

class ProductsController extends Controller
{
    //
    public function index()
    {

    }

    public function create()
    {
        $data = [];
        $data['brands'] = Brand::active()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['categories'] = Category::active()->select('id')->get();
        return view('dashboard.products.general.create',$data);
    }


    public function store(GeneralProductRequest $request)
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
            return redirect()->route('admin.maincategories')->with(['success' => 'تم الحفظ بنجاح']);
            

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function edit($id)
    {
        //get specific categories and its translations
        $category = Category::find($id);

        if (!$category)
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);

        return view('dashboard.categories.edit', compact('category'));
    }


    public function update($id, MainCategoryRequest $request)
    {


        try {
            $category=Category::find($id);

            if(!$category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);    

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            $category -> update($request->all());

            //save translation
            //field 'name' in table 'category_translations'
            $category->name = $request->name;

            $category->save();



            return redirect()->route('admin.maincategories')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {

            $category = Category::find($id);
            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);


            $category->delete();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم حذف القسم بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function changeStatus($id)
    {
        // try {
        //     $maincategory = MainCategory::find($id);
        //     if (!$maincategory)
        //         return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);

        //    $status =  $maincategory -> active  == 0 ? 1 : 0;

        //    $maincategory -> update(['active' =>$status ]);

        //     return redirect()->route('admin.maincategories')->with(['success' => ' تم تغيير الحالة بنجاح ']);

        // } catch (\Exception $ex) {
        //     return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        // }
    }
}
