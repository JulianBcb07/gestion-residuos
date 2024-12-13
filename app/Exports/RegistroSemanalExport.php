<?php

namespace App\Exports;

use App\Models\ZonasAreas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegistroSemanalExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{

    protected $fecha;
    protected $registros;

    public function __construct($registros, $fecha)
    {
        $this->fecha = $fecha;
        $this->registros = $registros;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Devuelve solo las columnas relevantes para el archivo
        return $this->registros->map(function ($registro) {
            return [
                'zona_id' => $registro->zona_id,
                'zona' => $registro->zona,
                'area_id' => $registro->area_id,
                'areaAsignada' => $registro->areaAsignada,
                'fecha' => $registro->fecha,
                'turno' => $registro->turno,
                'valor_kg' => $registro->valor_kg,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Zona ID',
            'Zona',
            'Área ID',
            'Área Asignada',
            'Fecha',
            'Turno',
            'Valor (kg)',
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
            'A' => 15, // Ancho de la columna A
            'B' => 30, // Ancho de la columna B
            'C' => 15,
            'D' => 35,
            'E' => 15,
            'F' => 15,
            'G' => 20,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Agregar el título en la primera fila
                $sheet->setCellValue('A1', 'Datos Generados en la fecha ' . $this->fecha);

                // Combinar celdas para el título
                $sheet->mergeCells('A1:G1');

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
                $sheet->getStyle('A2:G2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                ]);

                // Aplicar el filtro automático a las columnas
                $sheet->setAutoFilter('A2:G2');
            },
        ];
    }
}
