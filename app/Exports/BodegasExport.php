<?php

namespace App\Exports;

use App\Models\BodegaProducto;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;

class BodegasExport implements
    WithColumnWidths,
    WithHeadings,
    FromCollection,
    WithProperties,
    WithTitle
{


    /**
     * @return \Illuminate\Support\Collection
     */

    function __construct($id)
    {
        $this->id = $id;
    }
    public function title(): string
    {
        return 'Informe Bodega';
    }
    public function properties(): array
    {
        return [
            'creator'        => 'Crearte',
            'title'          => 'Informe Bodega',
        ];
    }

    public function headings(): array
    {
        return [
            'Material',
            'Descripción',
            'Unidad',
            'Precio',
            'Existencia',
            'Fecha',
            'Proveedor'
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 35,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 20,
            'G' => 40
        ];
    }


    public function informeBodega()
    {
        try {
            $productosBodega = BodegaProducto::with('producto', 'producto.unidad', 'ingreso.orden_compra.cotizacion.solicitud.tipo_solicitud', 'producto.proveedor')->where('bp_existencia', ">", 0)->get();

            $datosProductos = [];

            foreach ($productosBodega as $key => $producto) {
                $fechaIngreso = Carbon::parse($producto->created_at)->format('d-m-Y H:i:s');
                $fechaIngreso = Carbon::create($fechaIngreso);
                $producto->fecha_ingreso = $fechaIngreso->format('d-m-Y H:i:s');

                $productoDato = [
                    'bp_producto_material' => $producto['producto']->producto_material,
                    'bp_producto_descripcion' => $producto['producto']->producto_descripcion,
                    'bp_producto_unidad' => $producto['producto']['unidad']->unidad_nombre,
                    'bp_precio' => $producto->bp_precio,
                    'bp_existencia' => $producto->bp_cantidad,
                    'bp_fecha' => $producto->fecha_ingreso,
                    'bp_proveedor' => $producto['producto']['proveedor']['proveedor_nombre']
                ];

                array_push($datosProductos, $productoDato);
            }
            return $datosProductos;
        } catch (\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }

    public function collection()
    {
        $informe = $this->informeBodega();
        return collect($informe);
    }
}
