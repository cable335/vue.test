<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductImg
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $product_id
 * @property string $img_path
 * @property int|null $sort
 *
 * @package App\Models
 */
class ProductImg extends Model
{
    protected $table = 'product_imgs';
    public static $snakeAttributes = false;

    protected $casts = [
        'product_id' => 'int',
        'sort' => 'int'
    ];

    protected $fillable = [
        'product_id',
        'img_path',
        'sort'
    ];
    public function product(){
        return $this->belongsTo(product::class, 'user_id');
    }
}
