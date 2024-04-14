<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'user_id',
        'shop_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }
    //   お気に入りに登録済かどうかを調べる
    public function scopeIsFavorite($query, $shopId, $userId)
    {
        return $query->where('shop_id', $shopId)->where('user_id', $userId);
    }
}
