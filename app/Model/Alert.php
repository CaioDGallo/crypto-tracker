<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $crypto_asset 
 * @property string $price 
 * @property string $direction 
 * @property string $email 
 */
class Alert extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'alerts';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'created_at', 'updated_at', 'crypto_asset', 'price', 'direction', 'email'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
