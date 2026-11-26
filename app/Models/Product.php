<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'prep_time',
        'short_description',
        'description',
        'customizable_ingredients',
        'image',
        'is_best_seller',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_best_seller' => 'boolean',
        ];
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    /**
     * Calificación promedio basada únicamente en reseñas de clientes
     */
    public function averageRating(): ?float
    {
        $avg = $this->reviews()->avg('rating');
        return $avg ? round((float) $avg, 1) : null;
    }

    /**
     * Total de opiniones de clientes
     */
    public function totalReviews(): int
    {
        return $this->reviews()->count();
    }

    /**
     * Lista de ingredientes personalizables para el cliente
     */
    public function getIngredientsListAttribute(): array
    {
        if (!empty($this->customizable_ingredients)) {
            $items = array_map('trim', explode(',', $this->customizable_ingredients));
            return array_filter($items);
        }

        $cat = strtolower($this->category ?? '');

        if (str_contains($cat, 'hamburguesa')) {
            return ['Cebolla', 'Pepinillos', 'Jitomate', 'Mayonesa', 'Mostaza', 'Salsa BBQ'];
        }
        if (str_contains($cat, 'pizza')) {
            return ['Orégano', 'Salsa Picante', 'Chimichurri', 'Champiñones'];
        }
        if (str_contains($cat, 'taco')) {
            return ['Cebolla', 'Cilantro', 'Salsa Verde', 'Salsa Roja', 'Limón'];
        }
        if (str_contains($cat, 'torta')) {
            return ['Cebolla', 'Jitomate', 'Aguacate', 'Frijoles', 'Chiles en Vinagre', 'Mayonesa'];
        }
        if (str_contains($cat, 'papa')) {
            return ['Sal Marina', 'Queso Cheddar', 'Salsa Picante', 'Catsup', 'Crema'];
        }

        return ['Cebolla', 'Salsa', 'Crema', 'Cilantro', 'Salsas Aparte'];
    }
}
