<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComentarioCurtida extends Model
{
    use HasFactory;

    protected $table = 'comentario_curtidas';

    protected $fillable = [
        'comentario_id',
        'user_id',
        'ip_address',
    ];

    public $timestamps = false; // Não precisa de updated_at

    /**
     * Relacionamento com Comentario
     */
    public function comentario()
    {
        return $this->belongsTo(Comentario::class);
    }

    /**
     * Relacionamento com User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Escopo: Ordenadas por data (mais recente primeiro)
     */
    public function scopeOrdenado($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
