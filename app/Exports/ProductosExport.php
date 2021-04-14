<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductosExport implements
    WithColumnWidths,
    WithHeadings,
    FromCollection,
    WithProperties,
    WithTitle
{


    /**
     * @return \Illuminate\Support\Collection
     */
    public function title(): string
    {
        return 'Informe Productos';
    }
    public function properties(): array
    {
        return [
            'creator'        => 'Crearte',
            'title'          => 'Informe Productos',
        ];
    }

    public function headings(): array
    {
        return [
            'Material',
            'Descripción',
            'Unidad',
            'Precio',
            'Proveedor',
            'Dirección',
            'Teléfono'
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 35,
            'C' => 15,
            'D' => 15,
            'E' => 45,
            'F' => 20,
            'G' => 15,
        ];
    }


    public function informeProveedor()
    {
        try {

            $productos = Producto::with('proveedor', 'unidad')->get();

            $salidaLargaProductos = [];

            foreach ($productos as $key => $producto) {

                $data = [
                    'producto_material' => $producto['producto_material'],
                    'producto_descripcion' => $producto['producto_descripcion'],
                    'producto_unidad' => $producto['unidad']['unidad_nombre'],
                    'producto_precio' => $producto['producto_precio'],
                    'proveedor_nombre' => $producto['proveedor']['proveedor_nombre'],
                    'proveedor_direccion' => $producto['proveedor']['proveedor_direccion'],
                    'proveedor_telefono' => $producto['proveedor']['proveedor_telefono']
                ];

                array_push($salidaLargaProductos, $data);
            }

            return $salidaLargaProductos;
        } catch (\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }

    public function collection()
    {
        $informe = $this->informeProveedor();
        return collect($informe);
    }
}
