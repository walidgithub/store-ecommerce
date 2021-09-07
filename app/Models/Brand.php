<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Brand extends Model
{
    use HasFactory;

    use Translatable;

    protected $with =['translations'];

    protected $fillable =['is_active','photo'];

    //return true and false instead 0 and 1
    protected $casts = ['is_active' => 'boolean'];

    //column that will be translated
    protected $translatedAttributes = ['name']; 

    //is_active is a column
    public function getActive(){
        return $this->is_active == 0 ? 'غير مفعل' : 'مفعل';
    }

    public function getPhotoAttribute($val){
        return ($val !== null) ? asset('assets/images/brands/'.$val) : "";
    }
}
