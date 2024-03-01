<?php

namespace App\Http\Resources;

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
            'nome' => $this->nome,
            'plataforma' => $this->plataforma,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
            'status' => $this->status,
        ];
    }
}
