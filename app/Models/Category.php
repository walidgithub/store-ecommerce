<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use HasFactory;

    use Translatable;

    protected $with =['translations'];

    //column that will be translated
    protected $translatedAttributes = ['name'];

    //hide translations [this a key translation]
    protected $hidden = ['translations'];

    protected $fillable =['parent_id','slug','is_active'];

    //return true and false instead 0 and 1
    protected $casts = ['is_active' => 'boolean'];

    //recieve query
    //we call parent only not scopeParent
    
    public function scopeParent($query){
        return $query -> whereNull('parent_id');
    }

    public function scopeChild($query){
        return $query -> whereNotNull('parent_id');
    }

    //is_active is a column
    public function getActive(){
        return $this->is_active == 0 ? 'غير مفعل' : 'مفعل';
    }

    //to get all categories that have parent_id not null
    public function _parent(){
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function scopeActive($query){
        return $query->where('is_active',1);
    }
}
