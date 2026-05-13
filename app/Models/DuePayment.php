<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuePayment extends Model
{
    protected $fillable = [
        'due_id',
        'resident_name',
        'resident_phone',
        'address',
        'amount',
        'status',
        'proof',
        'note',
        'admin_note',
        'confirmed_at'
    ];

    protected $casts = ['confirmed_at' => 'datetime'];

    public function due()
    {
        return $this->belongsTo(Due::class);
    }

    public function isPending()   { return $this->status === 'pending'; }
    public function isConfirmed() { return $this->status === 'confirmed'; }
    public function isRejected()  { return $this->status === 'rejected'; }
}