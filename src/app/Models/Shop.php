<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public $sortable = ['rating'];

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

    // 平均評価順にソート
    public function averageRatingAscSortable($query)
    {
        return $query->join('ratings', 'shops.id', '=', 'ratings.shop_id')
                    ->select('shops.*')
                    ->groupBy('shops.id')
                    ->orderByRaw('AVG(ratings.rating) ASC');

    }

    // 平均評価降順にソート
    public function averageRatingDescSortable($query)
    {
        return $query->Leftjoin('ratings', 'shops.id', '=', 'ratings.shop_id')
                    ->select('shops.*')
                    ->groupBy('shops.id')
                    ->orderByRaw('AVG(ratings.rating) DESC');
    }
}
