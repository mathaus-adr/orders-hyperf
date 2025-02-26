<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property string $name 
 * @property string $quantity 
 * @property string $price 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class OrderItem extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'order_items';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['quantity', 'price', 'name', 'order_id'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
