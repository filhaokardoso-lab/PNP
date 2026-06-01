<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComentarioResposta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comentario_respostas';

    protected $fillable = [
        'comentario_id',
        'user_id',
        'nome',
        'email',
        'resposta',
        'anonimo',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'anonimo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

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
     * Escopo: Apenas respostas não deletadas
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Escopo: Ordenadas por data (mais recente primeiro)
     */
    public function scopeOrdenado($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
