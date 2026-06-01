<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $fillable = ['filename', 'category', 'description'];

    public static $categories = [
        // 'geral' => 'Geral',
        'apresentacoes' => 'Apresentações',
        'danca' => 'Dança',
        'musica' => 'Música',
        'poesia' => 'Poesia',
        'artes-visuais' => 'Artes Visuais',
        'bastidores' => 'Bastidores',
        'publico' => 'Público',
    ];
}
