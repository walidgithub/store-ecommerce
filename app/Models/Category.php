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

    protected $hidden = ['translations'];

    protected $fillable =['parent_id','slug','is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
