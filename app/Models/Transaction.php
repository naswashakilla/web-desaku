<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'type', 'title', 'amount', 'category',
        'description', 'date', 'user_id'
    ];

    protected $casts = ['date' => 'date'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isIncome()  { return $this->type === 'income'; }
    public function isExpense() { return $this->type === 'expense'; }
}