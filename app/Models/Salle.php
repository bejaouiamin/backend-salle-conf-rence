<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $fillable = ['nom', 'capacite', 'localisation', 'equipements'];


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
