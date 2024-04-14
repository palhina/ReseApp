<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'area_id',
        'genre_id',
        'manager_id',
        'shop_name',
        'shop_photo',
        'shop_comment'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }
    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id', 'id');
    }
}
