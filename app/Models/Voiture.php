<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voiture extends Model
{
    use HasFactory;

    protected $table = 'voitures';
    
    protected $fillable = [
        'matricule', 
        'modele', 
        'carburant', 
        'prix', 
        'photo'
    ];

    public function locations()
    {
        return $this->hasMany(Location::class, 'voiture_id');
    }
    
    // Vérifier si la voiture est disponible
    public function isDisponible()
    {
        // Une voiture est indisponible si elle a des locations actives
        return $this->locations()->whereDate('datedebut', '<=', now())
            ->whereRaw('DATE_ADD(datedebut, INTERVAL nombrejours DAY) >= ?', [now()])
            ->count() == 0;
    }
    
    // Calculer le statut de disponibilité
    public function getStatusAttribute()
    {
        return $this->isDisponible() ? 'Disponible' : 'Indisponible';
    }
    
    // Extraire la marque à partir du modèle
    public function getMarqueAttribute()
    {
        // Simplement prendre le premier mot du modèle comme marque
        $parts = explode(' ', $this->modele);
        return $parts[0];
    }
}