<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    // Indicar o nome da tabela
    protected $table = 'cursos';

    // Indicar quais colunas podem ser cadastradas
    protected $fillable = ['nome', 'plataforma', 'data_inicio', 'data_fim'];
}
