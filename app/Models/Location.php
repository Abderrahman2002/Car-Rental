<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'voiture_id',
        'datedebut',
        'nombrejours'
    ];

    public function voiture()
    {
        return $this->belongsTo(Voiture::class, 'voiture_id');
    }
    
    // Calculer le montant total de la location
    public function getMontantAttribute()
    {
        return $this->voiture->prix * $this->nombrejours;
    }
}