<?php

namespace App\Exports;
use Illuminate\Support\Collection;


use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Cliente;
use App\Models\DetalleSolicitud;
use App\Models\SalidaProducto;
use Illuminate\Support\Carbon;

use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;

use Maatwebsite\Excel\Concerns\WithTitle;

class ClientesExport implements
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
        return 'Informe Cliente';
    }
    public function properties(): array
    {
        return [
            'creator'        => 'Crearte',
            'title'          => 'Informe Clientes',
        ];
    }

    public function headings(): array
    {
        return [
            'Material',
            'Descripción',
            'Unidad',
            'Precio',
            'Cantidad',
            'Total',
            'Proveedor',
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
            'F' => 15,
            'G' => 40,
        ];
    }


    public function informeClientes()
    {
        try {
            $cliente = Cliente::with('proyecto', 'proyecto.centro_costo')->find($this->id);

            $detalleSolicitud = DetalleSolicitud::where('ds_cliente_id', $cliente->id)->where('ds_proyecto_id', $cliente->proyecto->id)->where('ds_centro_costo_id', $cliente->proyecto->centro_costo->id)->first();

            $salidaProductos = SalidaProducto::with('salida', 'producto', 'producto.unidad', 'producto.proveedor')->where('sp_detalle_solicitud_id', $detalleSolicitud->id)->get();

            $productos = [];

            $total = 0;

            $excel = [];

            foreach ($salidaProductos as $key => $producto) {
                $fechaIngreso = Carbon::parse($producto->created_at)->format('d-m-Y H:i:s');
                $fechaIngreso = Carbon::create($fechaIngreso);
                $producto->fecha_ingreso = $fechaIngreso->format('d-m-Y H:i:s');

                $total += $producto->sp_total;
               /*  $producto->sp_total = "$ " . number_format($producto->sp_total, NULL, ",", ".");
                $producto->sp_precio = "$ " . number_format($producto->sp_precio, NULL, ",", ".");
                array_push($productos, $producto); */

                $excel[$key]['producto_material'] = $producto['producto']['producto_material'];
                $excel[$key]['producto_descripcion'] = $producto['producto']['producto_material'];
                $excel[$key]['producto_unidad'] = $producto['producto']['unidad']['unidad_nombre'];
                $excel[$key]['producto_precio'] = $producto['sp_precio'];
                $excel[$key]['producto_cantidad'] = $producto['sp_cantidad'];
                $excel[$key]['producto_total'] = $producto['sp_total'];
                $excel[$key]['producto_proveedor'] = $producto['producto']['proveedor']['proveedor_nombre'];
            }

            $datoTotal = [
                'totalProductos' => "$ " . number_format($total, NULL, ",", ".")
            ];

            $dataExcel = [
                'productos' => $productos,
                'total' => $total,
                'cliente' => $cliente
            ];
            return $excel;
        } catch (\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }

    public function collection()
    {
        $informe = $this->informeClientes();
        return collect($informe);
    }
}
