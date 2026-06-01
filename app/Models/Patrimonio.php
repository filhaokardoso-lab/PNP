<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrimonio extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descricao',
        'categoria',
        'marca',
        'modelo',
        'numero_serie',
        'data_aquisicao',
        'valor_aquisicao',
        'setor_localizacao',
        'situacao',
        'imagem',
    ];

    protected $casts = [
        'data_aquisicao' => 'date',
        'valor_aquisicao' => 'decimal:2',
    ];
}
