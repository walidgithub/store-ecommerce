<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    use Translatable;

    use SoftDeletes;

    protected $with =['translations'];

    protected $fillable =['brand_id',
    'slug',
    'sku',
    'price',
    'special_price',
    'special_price_type',
    'special_price_start',
    'special_price_end',
    'selling_price',
    'manage_stock',
    'qty',
    'in_stock',
    'is_active',
    'brand_id '];

    protected $casts = [
        'is_active' => 'boolean',
        'in_stock' => 'boolean',
        'manage_stock' => 'boolean', ];


    protected $dates=[
        'special_price_start',
        'special_price_end',
        'deleted_at'
    ];

    //column that will be translated
    protected $translatedAttributes = ['name','description','short_description'];

    //one to many relationship
    //withDefault if it return null
    public function brand(){
        return $this->belongsTo(Brand::class)->withDefault();
    }

    //many to many relationship
    public function categories(){
        return $this->belongsToMany(Category::class,'product_categories');
    }

    //many to many relationship
    public function tags(){
        return $this->belongsToMany(Tag::class,'product_tags');
    }
}
