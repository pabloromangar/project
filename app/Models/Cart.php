<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Definir la relación con el modelo Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Definir la relación con el modelo User (si tienes un modelo de User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
