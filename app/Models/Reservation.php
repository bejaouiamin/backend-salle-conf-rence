<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'salle_id',
        'user_id',
        'start_time',
        'end_time',
        'preferences',
        'resources',
        'email',
    ];


    // Relation avec le modèle Salle
    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
