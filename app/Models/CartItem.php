<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'notes',
        'is_selected',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'is_selected' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getUnitPriceAttribute(): float
    {
        $base = (float) ($this->product ? $this->product->price : 0);
        $notes = strtolower($this->notes ?? '');
        
        // Modificadores de tamaño sustanciales para Pizza (al menos $25 - $35 de diferencia)
        if (str_contains($notes, 'mediana')) {
            $base += 30.00;
        } elseif (str_contains($notes, 'familiar') || str_contains($notes, 'grande')) {
            $base += 65.00;
        }
        
        // Modificadores de presentación para Bebidas / Jarritos / Refrescos
        if (str_contains($notes, '600 ml')) {
            $base += 10.00;
        } elseif (str_contains($notes, '2 litro') || str_contains($notes, '2l') || str_contains($notes, '2 l')) {
            $base += 28.00;
        }

        return $base;
    }

    public function getSubtotalAttribute(): float
    {
        return (float) ($this->quantity * $this->unit_price);
    }
}
