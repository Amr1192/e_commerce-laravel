<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'quantity',
        'unit_price',
        'line_total',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'line_total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (OrderItem $item): void {
            if (! $item->product_id) {
                return;
            }
            $product = Product::query()->find($item->product_id);
            if (! $product) {
                return;
            }
            if (empty($item->product_name)) {
                $item->product_name = $product->name;
            }
            if (empty($item->product_sku)) {
                $item->product_sku = $product->sku;
            }
        });

        static::saving(function (OrderItem $item): void {
            $item->line_total = round((float) $item->quantity * (float) $item->unit_price, 2);
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
