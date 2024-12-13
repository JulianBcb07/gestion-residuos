<?php

namespace App\Exports;

use App\Models\GenSubproducto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegistroSubproductosExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{

    protected $inicio;
    protected $final;
    protected $datosGenerados;

    public function __construct($datosGenerados, $inicio, $final)
    {
        $this->inicio = $inicio;
        $this->final = $final;
        $this->datosGenerados = $datosGenerados;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->datosGenerados->map(function ($datosGenerados) {
            return [
                'subproducto_id' => $datosGenerados->subproducto_id,
                'subproducto_nombre' => $datosGenerados->subproducto_nombre,
                'fecha' => $datosGenerados->fecha,
                'total_kg' => $datosGenerados->total_kg,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Subproducto ID',
            'Subproducto',
            'Fecha',
            'Total (kg)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para los encabezados
            1 => ['font' => ['bold' => true]],

            // Opcional: Estilo para una columna específica (ejemplo: B)
            'B' => ['font' => ['italic' => true]],

            // Estilo general para el resto
            'A1:G100' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Ancho de la columna A
            'B' => 35, // Ancho de la columna B
            'C' => 25,
            'D' => 20,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Agregar el título en la primera fila
                $sheet->setCellValue('A1', 'Datos Generados en la fecha ' . $this->inicio . '-' . $this->final);

                // Combinar celdas para el título
                $sheet->mergeCells('A1:D1');

                // Aplicar estilos al título
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'color' => ['argb' => '0a0a0a'],
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                // Ajustar la altura de la fila del título
                $sheet->getRowDimension('1')->setRowHeight(30);

                // Insertar los encabezados en la fila 2
                $headings = $this->headings();
                foreach ($headings as $index => $heading) {
                    $sheet->setCellValueByColumnAndRow($index + 1, 2, $heading);
                }

                // Estilo para los encabezados
                $sheet->getStyle('A2:D2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                // Aplicar el filtro automático a las columnas
                $sheet->setAutoFilter('A2:D2');
            },
        ];
    }
}
