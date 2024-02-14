<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PedidoStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pedido_status')->insert([
            [ 'descricao' => 'Solicitado'],
            [ 'descricao' => 'Concluído'],
            [ 'descricao' => 'Cancelado'],
        ]);
    }
}
