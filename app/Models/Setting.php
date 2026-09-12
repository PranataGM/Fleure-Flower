<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
    protected $fillable = ['store_name', 'whatsapp', 'instagram', 'address', 'maps_embed'];

    public static function getSetting(): ?self {
        return static::first();
    }
}
