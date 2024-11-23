<?php

namespace App\Exports;

use App\Models\Custom;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomsExport implements FromView, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $startDate;
    protected $endDate;

    // Constructor que acepta startDate y endDate
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    
    public function view(): View
    {

        $customs = Custom::whereBetween('date_register', [$this->startDate, $this->endDate])
                         ->where('state', 'Generado') // Ajusta el estado según lo que necesites
                         ->get();

        return view('points.exports.custom.custom-export', [

            'customs' => $customs

        ]);
    }


    public function styles(Worksheet $sheet)
    {
        // Aplicar estilos a celdas o rangos
        return [
            // Centrar el texto en todo el documento
            'A1:N1000' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Negro
                    ],
                ],
            ],
            // Aplicar negrita al encabezado
            1 => [
                'font' => [
                    'bold' => true,
                    'color' =>  ['argb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => '2e37a4'], // Fondo azul
                ],
            ],
        ];
    }

}
