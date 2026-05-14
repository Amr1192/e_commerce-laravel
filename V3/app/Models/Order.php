<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'currency',
        'subtotal',
        'tax_total',
        'shipping_total',
        'discount_total',
        'grand_total',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax_total' => 'decimal:2',
            'shipping_total' => 'decimal:2',
            'discount_total' => 'decimal:2',
            'grand_total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order): void {
            if (empty($order->order_number)) {
                $order->order_number = self::generateUniqueOrderNumber();
            }
        });
    }

    public static function generateUniqueOrderNumber(): string
    {
        do {
            $number = 'ORD-'.now()->format('ymd').'-'.strtoupper(bin2hex(random_bytes(3)));
        } while (self::query()->where('order_number', $number)->exists());

        return $number;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Human-readable status for UI (list + detail).
     *
     * @return array{label: string, description: string, badge: string}
     */
    public function statusPresentation(): array
    {
        return match ($this->status) {
            'pending' => [
                'label' => 'Pending',
                'description' => 'Your order is saved and waiting for payment or staff confirmation.',
                'badge' => 'bg-amber-50 text-amber-900 ring-amber-200',
            ],
            'paid' => [
                'label' => 'Paid',
                'description' => 'Payment was received. Fulfillment will begin shortly.',
                'badge' => 'bg-emerald-50 text-emerald-900 ring-emerald-200',
            ],
            'processing' => [
                'label' => 'Processing',
                'description' => 'We are picking and packing your items.',
                'badge' => 'bg-sky-50 text-sky-900 ring-sky-200',
            ],
            'shipped' => [
                'label' => 'Shipped',
                'description' => 'Your order has left our facility and is in transit.',
                'badge' => 'bg-indigo-50 text-indigo-900 ring-indigo-200',
            ],
            'delivered' => [
                'label' => 'Delivered',
                'description' => 'Delivery is complete. Thank you for your purchase.',
                'badge' => 'bg-green-50 text-green-900 ring-green-200',
            ],
            'cancelled' => [
                'label' => 'Cancelled',
                'description' => 'This order was cancelled and will not be charged further.',
                'badge' => 'bg-gray-100 text-gray-800 ring-gray-200',
            ],
            'refunded' => [
                'label' => 'Refunded',
                'description' => 'A refund was issued according to store policy.',
                'badge' => 'bg-violet-50 text-violet-900 ring-violet-200',
            ],
            default => [
                'label' => Str::title(str_replace('_', ' ', (string) $this->status)),
                'description' => 'Status updates will appear here as your order progresses.',
                'badge' => 'bg-gray-50 text-gray-900 ring-gray-200',
            ],
        };
    }
}
