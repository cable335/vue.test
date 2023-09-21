<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $name
 * @property int|null $price
 * @property int|null $public
 * @property string|null $desc
 *
 * @package App\Models
 */
class Product extends Model
{
    protected $table = 'products';
    public static $snakeAttributes = false;

    protected $casts = [
        'price' => 'int',
        'public' => 'int'
    ];

    protected $fillable = [
        'name',
        'img_path',
        'price',
        'public',
        'desc'
    ];

    public function cart(){
        return $this->hasMany(Cart::class, 'id', 'product_id');
    }

    public function productImg(){
        return $this->hasMany(ProductImg::class,'id', 'product_id');
    }
}
