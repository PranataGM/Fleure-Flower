<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model {
    protected $fillable = [
        'order_code', 'customer_name', 'customer_phone', 'customer_email',
        'shipping_address', 'city', 'total_amount', 'status',
        'snap_token', 'payment_type', 'transaction_id', 'notes',
    ];

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'pending'    => 'Menunggu Pembayaran',
            'paid'       => 'Sudah Dibayar',
            'processing' => 'Sedang Diproses',
            'shipped'    => 'Sedang Dikirim',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => $this->status,
        };
    }

    public function getStatusColorAttribute(): string {
        return match($this->status) {
            'paid', 'completed' => 'green',
            'processing', 'shipped' => 'blue',
            'cancelled' => 'red',
            default => 'yellow',
        };
    }

    public function getFormattedTotalAttribute(): string {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }
}
