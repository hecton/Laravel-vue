<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\AfterSheet;

class PedidoExport implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pedido::with(['cliente', 'pedido_status', 'imagem' => function ($query) {
            $query->limit(1);
        }])->get();
    }

    /**
     * headings
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Produto',
            'Valor',
            'Data',
            'Cliente',
            'Status do pedido',
            'Ativo',
        ];
    }

    /**
    * @param Pedido $pedido
    */
    public function map($pedido): array
    {
        $data = new Carbon($pedido->data);

        return [
            'produto' => $pedido->produto,
            'valor' => 'R$ '.number_format($pedido->valor, 2,",","."),
            'data' => $data->format('d/m/Y'),
            'cliente' => $pedido->cliente->nome,
            'pedido_status_id' => $pedido->pedido_status->descricao,
            'ativo' => $pedido->ativo? 'Sim' : 'Não',
        ];
    }

    public function registerEvents():array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDefaultRowDimension()->setRowHeight(35);
                $workSheet = $event->sheet->getDelegate();
                $this->setImages($workSheet);
            },
        ];
    }

    public function setImages($workSheet)
    {
        $this->collection()->each( function( $pedido, $index ) use( $workSheet ) {
            if($pedido->imagem->count()){
                $drawing = new Drawing();
                $drawing->setName($pedido->produto);
                $drawing->setPath($pedido->imagem[0]->capa_full_path);
                $drawing->setHeight(40);
                $drawing->setWidth(40);
                $drawing->setCoordinates('G'.($index+2));
                $drawing->setWorksheet($workSheet);
            }
        });
    }
}
