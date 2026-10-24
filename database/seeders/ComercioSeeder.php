<?php

namespace Database\Seeders;

use App\Models\Comercio;
use App\Models\User;
use Illuminate\Database\Seeder;

class ComercioSeeder extends Seeder
{
    public function run(): void
    {
        $ana = User::where('email', 'ana@example.com')->firstOrFail();
        $carlos = User::where('email', 'carlos@example.com')->firstOrFail();

        $cafeAmanecer = Comercio::firstOrCreate(
            ['nombre_comercio' => 'Café Amanecer'],
            [
                'rubro' => 'Restaurante',
                'telefono' => '2222-1234',
            ]
        );

        $cafeAmanecer->update(['user_id' => $ana->id]);

        $ferreteria = Comercio::firstOrCreate(
            ['nombre_comercio' => 'Ferretería El Tornillo'],
            [
                'rubro' => 'Ferretería',
                'telefono' => '2222-5678',
            ]
        );

        $ferreteria->update(['user_id' => $carlos->id]);

        $pupuseria = Comercio::firstOrCreate(
            ['nombre_comercio' => 'Pupusería Doña Marta'],
            [
                'rubro' => 'Restaurante',
                'telefono' => '2222-9012',
            ]
        );

        $pupuseria->update(['user_id' => $carlos->id]);
    }
}
