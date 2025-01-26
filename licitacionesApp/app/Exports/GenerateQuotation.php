<?php

namespace App\Exports;

use App\Models\Tax;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GenerateQuotation implements FromCollection, WithHeadings, 
    WithMapping, ShouldAutoSize, WithColumnFormatting, WithStyles,
    WithColumnWidths,WithEvents
{

    use RegistersEventListeners;

    protected $profit_percentage;
    protected $items;
    protected static $priceFormat = "[$$-CO] #,##0.00";
    protected $tax_multiplier_total;

    // Constructor para recibir el porcentaje de ganancia
    public function __construct($profit_percentage, $items)
    {
        $this->profit_percentage = $profit_percentage;
        $this->items = $items;
        $this->tax_multiplier_total = Tax::first()->total_with_tax_multiplier;
    }

    /**
    * @return array
    */
    public function collection()
    {
        //
        return collect($this->items);
    }

    /**
     * Define las cabeceras de las columnas
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID', 'Nombre', 'Descripcion', 'Cantidad a adquirir', 'Unidad de medida',
            'Precio Unitario - Sin IVA', 'Precio Unitario - Con IVA', 
            'Total', 'Total con Ganancias', 'Porcentaje de Ganancia', 'Proveedor',
            'Marca', 'Notas'
        ];
    }

    /**
     * Mapea los datos de cada fila para incluir las columnas calculadas
     *
     * @param  mixed $product
     * @return array
     */
    public function map($product): array
    {
        $unit_price_with_tax = $product['unit_price_withouth_tax'] * $this->tax_multiplier_total ; // Precio con IVA
        $total_with_tax = $unit_price_with_tax * $product['quantity']; // Precio total con IVA
        $total_with_profit = $total_with_tax * (1 + ($this->profit_percentage / 100)); // Total con ganancia

        return [
            $product['id'],
            $product['name'],
            $product['description'] ?? 'N/A',
            $product['quantity'],
            $product['unit_of_measure'] ?? 'N/A',
            $product['unit_price_withouth_tax'],
            $unit_price_with_tax,
            $total_with_tax,
            $total_with_profit,
            $this->profit_percentage . '%', // Mostrar el porcentaje de ganancia
            $product['supplier'] ?? 'N/A',
            $product['brand'] ?? 'N/A',
            $product['notes'] ?? 'N/A',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => static::$priceFormat,
            'F' => static::$priceFormat,
            'H' => static::$priceFormat,
            'I' => static::$priceFormat,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        /* Estilos a la primera fila, la de los titulos. */
        $sheet->getStyle('A1:M1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFC107'], 
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'font' => [
                'bold' => true, 
            ],
            'alignment' => [
                    'wrapText'  => true
                ]
        ]);
        $tableRange = "A1:". $sheet->getHighestColumn() . $sheet->getHighestDataRow();

        $sheet->getStyle($tableRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Bordes negros
                ],
            ],
        ]);
       
    }

    public function columnWidths(): array
    {
        return [
            'c' => 55,
            'd' => 15,
            'f' => 20,
            'g' => 20,
            'h' => 20,
            'i' => 20,
            'J' => 15,
            'm' => 55,            
        ];
    }

    /**
     * Evento para modificar la hoja después de que se genere.
     */
    public static function afterSheet(AfterSheet $event)
    {
        // Columnas a sumar
        $columnsToSum = ['H', 'I'];
        $sheet = $event->sheet;
        $highestRow = $sheet->getHighestRow(); // Última fila con datos
        foreach($columnsToSum as $column) {
            
            $totalCell = $column . ($highestRow + 1);

            // Fórmula para calcular la primera celda de la columna, y la ultima
            $sumFormula = "=SUM(".$column."2:$column" . $highestRow . ')';

            // Escribir el total en la celda específica
            $sheet->setCellValue($totalCell, $sumFormula);

            // Aplicar formato 
            $sheet->getStyle($totalCell)->getFont()->setBold(true);
            $sheet->getStyle($totalCell)->getNumberFormat()->setFormatCode(self::$priceFormat); // Moneda o formato numérico
        }
        //Colorear columnas:
        $sheet->getStyle('H1:H'.$sheet->getHighestRow())->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '34ff07'], // Color verde
            ],
        ]);
        $sheet->getStyle('I1:I'.$sheet->getHighestRow())->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0787ff'], // Color azul
            ],
        ]);
        //centrar en documento.
        $sheet->getDelegate()->getStyle($sheet->calculateWorksheetDimension())->getAlignment()
            ->setHorizontal('center')
            ->setVertical('center');


        
    }
}
