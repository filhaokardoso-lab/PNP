<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comentarios';

    protected $fillable = [
        'nome',
        'email',
        'categoria',
        'comentario',
        'anonimo',
        'user_id',
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
     * Relacionamento com User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com Respostas
     */
    public function respostas()
    {
        return $this->hasMany(ComentarioResposta::class)->active()->ordenado();
    }

    /**
     * Relacionamento com Curtidas
     */
    public function curtidas()
    {
        return $this->hasMany(ComentarioCurtida::class);
    }

    /**
     * Escopo: Apenas comentários não deletados
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Escopo: Comentários ordenados por data (mais recente primeiro)
     */
    public function scopeOrdenado($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Escopo: Filtrar por categoria
     */
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }
}
