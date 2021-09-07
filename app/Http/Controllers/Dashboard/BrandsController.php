<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;

class BrandsController extends Controller
{
    //
    public function index(){
        $brands = Brand::orderBy('id','DESC')->paginate(PAGINATION_COUNT);

        return view('dashboard.brands.index', compact('brands'));
    }

    public function create(){
        return view('dashboard.brands.create');
    }

    public function store(BrandRequest $request)
    {

        try {  

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $fileName = "";
            if ($request->has('photo')) {

                $fileName = uploadImage('brands', $request->photo);
            }

            DB::beginTransaction();

            $brand = Brand::create($request->except('_token','photo'));

            //save translation
            //field 'name' in table 'brand_translations'
            $brand->name = $request->name;
            $brand->photo = $fileName;
            $brand->save();

            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم الحفظ بنجاح']);
            

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function edit($id)
    {
        //get specific brands and its translations
        $brand = Brand::find($id);

        if (!$brand)
            return redirect()->route('admin.brands')->with(['error' => 'هذه الماركة غير موجودة ']);

        return view('dashboard.brands.edit', compact('brand'));
    }


    public function update($id, BrandRequest $request)
    {


        try {
            $brand=Brand::find($id);

            if(!$brand)
                return redirect()->route('admin.brands')->with(['error' => 'هذه الماركة غير موجودة']);    

            DB::beginTransaction();

            $fileName = "";
            if ($request->has('photo')) {
                $fileName = uploadImage('brands', $request->photo);
                Brand::where('id',$id)->update(['photo' => $fileName]);
            }

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            $brand -> update($request->except('_token','id','photo'));

            //save translation
            //field 'name' in table 'brand_translations'
            $brand->name = $request->name;

            $brand->save();


            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {

            $brand = Brand::find($id);
            if (!$brand)
                return redirect()->route('admin.brands')->with(['error' => 'هذا العنصر غير موجود ']);


            $brand->delete();
            return redirect()->route('admin.brands')->with(['success' => 'تم حذف العنصر بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}
