<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory;

    protected $fillable = ['name', 'category', 'description', 'price', 'image', 'status'];

    public function scopeAvailable($query) {
        return $query->where('status', 'available');
    }

    public function getFormattedPriceAttribute(): string {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getImageUrlAttribute(): string {
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/products/' . $this->image);
    }

    public function getCategoryLabelAttribute(): string {
        return match($this->category) {
            'buket'        => 'Buket',
            'fresh_flower' => 'Fresh Flower',
            'amplop'       => 'Amplop & Kartu',
            default        => $this->category,
        };
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }
}
