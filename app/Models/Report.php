<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title', 'category', 'description', 'location',
        'photo', 'reporter_name', 'reporter_phone', 'status'
    ];

    public function updates()
    {
        return $this->hasMany(ReportUpdate::class);
    }

    public function latestUpdate()
    {
        return $this->hasOne(ReportUpdate::class)->latestOfMany();
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'process' => 'Diproses',
            'done'    => 'Selesai',
            default   => '-'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'process' => 'blue',
            'done'    => 'green',
            default   => 'gray'
        };
    }
}