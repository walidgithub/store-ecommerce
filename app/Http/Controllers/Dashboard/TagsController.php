<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    //
    public function index(){
        $tags = Tag::orderBy('id','DESC')->paginate(PAGINATION_COUNT);

        return view('dashboard.tags.index', compact('tags'));
    }

    public function create(){
        return view('dashboard.tags.create');
    }

    public function store(TagRequest $request)
    {

        try {  

            DB::beginTransaction();

            $tag = Tag::create($request->except('_token'));

            //save translation
            //field 'name' in table 'tag_translations'
            $tag->name = $request->name;
            $tag->save();

            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم الحفظ بنجاح']);
            

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function edit($id)
    {
        //get specific tags and its translations
        $tag = Tag::find($id);

        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => 'هذه العنصر غير موجود ']);

        return view('dashboard.tags.edit', compact('tag'));
    }


    public function update($id, TagRequest $request)
    {


        try {
            $tag=Tag::find($id);

            if(!$tag)
                return redirect()->route('admin.tags')->with(['error' => 'هذه العنصر غير موجود']);    

            DB::beginTransaction();

            $tag -> update($request->except('_token','id'));

            //save translation
            //field 'name' in table 'tag_translations'
            $tag->name = $request->name;

            $tag->save();


            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم التحديث بنجاح']);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {

            $tag = Tag::find($id);
            if (!$tag)
                return redirect()->route('admin.tags')->with(['error' => 'هذا العنصر غير موجود ']);


            $tag->delete();
            return redirect()->route('admin.tags')->with(['success' => 'تم حذف العنصر بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
}
