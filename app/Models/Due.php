<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Due extends Model
{
    protected $fillable = ['name', 'amount', 'month', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function payments()
    {
        return $this->hasMany(DuePayment::class);
    }

    public function confirmedPayments()
    {
        return $this->hasMany(DuePayment::class)->where('status', 'confirmed');
    }

    // Total terkumpul dari iuran ini
    public function totalCollected()
    {
        return $this->confirmedPayments()->sum('amount');
    }
}