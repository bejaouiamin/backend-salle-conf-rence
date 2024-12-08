<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['salle_id', 'start_time', 'end_time', 'preferences', 'resources','email'];

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
}
