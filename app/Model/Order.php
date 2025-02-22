<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;
use Hyperf\Testing\Concerns\InteractsWithModelFactory;

/**
 * @property int $id 
 * @property string $total 
 * @property string $external_order_id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Order extends Model
{
    use InteractsWithModelFactory;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'orders';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['external_order_id', 'total', 'client_id'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
