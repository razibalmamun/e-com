<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'status'
    ];

    public function image(){
        return $this->morphOne(Image::class , 'imageable');
    }

    public function scopeFilter($query, $request) {
        return $query->where('name', 'like', '%'.$request->input('search').'%');
    }
}
