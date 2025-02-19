<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id
 * @property string $external_client_id
 * @property int $order_quantity
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Client extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'clients';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['external_client_id'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [
        'id' => 'integer', 'order_quantity' => 'integer'
    ];
}