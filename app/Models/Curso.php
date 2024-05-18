<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    use HasFactory, SoftDeletes;

    // Indicar o nome da tabela
    protected $table = 'cursos';

    // Indicar quais colunas podem ser cadastradas
    protected $fillable = ['nome', 'plataforma', 'status', 'data_inicio', 'data_fim'];
}
