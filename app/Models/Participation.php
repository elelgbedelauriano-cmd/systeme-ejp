<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nouveau_id', 
        'programme_id', 
        'present', // AJOUTÉ (booléen: true=présent, false=absent)
        'statut', 
        'motif_absence', 
        'marque_par'
    ];
    
    protected $casts = [
        'statut' => 'string',
        'present' => 'boolean', // AJOUTÉ
    ];
    
    public function nouveau()
    {
        return $this->belongsTo(Nouveau::class);
    }
    
    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }
    
    public function marquePar()
    {
        return $this->belongsTo(User::class, 'marque_par');
    }
}