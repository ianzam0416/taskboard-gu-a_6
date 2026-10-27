<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransaccionResource extends JsonResource
{
    /**
     * Transformar la transacción en un arreglo para la respuesta JSON.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comercio_id' => $this->comercio_id,
            'monto' => $this->monto,
            'cliente_nombre' => $this->cliente_nombre,
            'estado' => $this->estado,
        ];
    }
}
