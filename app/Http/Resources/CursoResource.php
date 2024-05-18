<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CursoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_user' => $this->id_user,
            'nome' => $this->nome,
            'plataforma' => $this->plataforma,
            'data_inicio' => Carbon::parse($this->data_inicio)->tz('America/Sao_Paulo')->format('d/m/Y'),
            'data_fim' => $data_fim = ($this->data_fim != null) ? Carbon::parse($this->data_fim)->tz('America/Sao_Paulo')->format('d/m/Y') : $this->data_fim,
            'status' => $this->status,
        ];
    }
}
