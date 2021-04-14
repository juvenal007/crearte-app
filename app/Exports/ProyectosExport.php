<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Proyecto;
use App\Models\DetalleSolicitud;
use App\Models\SalidaProducto;


use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProyectosExport implements
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
        return 'Informe Proyecto';
    }
    public function properties(): array
    {
        return [
            'creator'        => 'Crearte',
            'title'          => 'Informe Proyecto',
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
            'Cliente ',
            'Proyecto',
            'Centro Costo',
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
            'H' => 20,
            'I' => 20,
            'J' => 20,
        ];
    }


    public function informeProyecto()
    {
        try {
            $proyecto = Proyecto::with('centro_costo')->find($this->id);

            $detalleSolicitud = DetalleSolicitud::where('ds_proyecto_id', $proyecto->id)->where('ds_centro_costo_id', $proyecto->proyecto_centro_costo_id)->where('ds_cliente_id', '!=', null)->get();

            $salidaLargaProductos = [];

            foreach ($detalleSolicitud as $key => $detalle) {
                $salidaProductos = SalidaProducto::with('salida', 'producto', 'producto.unidad', 'producto.proveedor', 'detalle_solicitud.cliente', 'detalle_solicitud.proyecto', 'detalle_solicitud.centro_costo')->where('sp_detalle_solicitud_id', $detalle->id)->get();
                if (count($salidaProductos) > 0) {

                    foreach ($salidaProductos as $key => $producto) {

                        $data = [
                            'producto_material' => $producto['producto']['producto_material'],
                            'producto_descripcion' => $producto['producto']['producto_descripcion'],
                            'producto_unidad' => $producto['producto']['unidad']['unidad_nombre'],
                            'producto_precio' => $producto['sp_precio'],
                            'producto_cantidad' => $producto['sp_cantidad'],
                            'producto_total' => $producto['sp_total'],
                            'producto_proveedor' => $producto['producto']['proveedor']['proveedor_nombre'],
                            'cliente' => $producto['detalle_solicitud']['cliente']['cliente_nombre'].' '.$producto['detalle_solicitud']['cliente']['cliente_apellido_paterno'],
                            'proyecto' => $producto['detalle_solicitud']['proyecto']['proyecto_nombre'],
                            'centro_costo' => $producto['detalle_solicitud']['centro_costo']['cc_nombre']
                        ];

                        array_push($salidaLargaProductos, $data);
                    }
                }
            }
            return $salidaLargaProductos;
        } catch (\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }

    public function collection()
    {
        $informe = $this->informeProyecto();
        return collect($informe);
    }
}
