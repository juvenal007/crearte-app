<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Comprobante Documento Solicitud</title>
</head>
<style>
    @page {
        margin: 0px;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0px;
    }

    table {
        border-collapse: collapse;
        margin: auto;
        width: 100% !important;
    }

    table,
    th,
    td {
        font-size: 0.7rem;
        border: 1px solid black;
        padding: 5px;
    }

    .noTable,
    .Cth,
    .Ctd {
        font-size: 0.7rem;
        padding: 5px;
        margin: none;
        border: none;
    }

    .borde {
        border: 1px solid black;
    }

    .logoLeft {
        text-align: left;
        float: left;
    }

    .logoRight {
        text-align: right;
        float: right;
    }

    .textCenter {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .textRight {
        text-align: right;
    }

    .imgCenter {
        text-align: center;
        display: block;
    }

    .paddingLeftRight {
        padding-left: 30px;
        padding-right: 30px;
    }

    .paddingRight {
        margin-right: 0px;
    }

    .textJustify {
        text-align: justify;
        text-justify: inter-word;
    }

    .mt-1 {
        margin-top: 1.5rem;
    }

    .mb-1 {
        margin-bottom: 0.5rem;
    }

    .mt {
        margin-top: 0;
    }

    .titulo {
        font-size: 0.8rem;
    }

    .center {
        text-align: center;
        margin: auto;
    }

    .row {
        margin: 15px;
        padding: 5px;
        padding-top: 5px;
        padding-right: 15px;
    }

    .tg {
        border: none;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .tg td {
        border: none;
        /*  border-color: black;
        border-style: solid; */

        font-family: Arial, sans-serif;
        font-size: 10px;
        overflow: hidden;
        padding: 2px 5px;
        word-break: normal;
    }

    .tg tr td:last-child {
        width: 1%;
        white-space: nowrap;
    }

    .tg th {
        border: none;
        /*  border-color: black;
        border-style: solid; */

        font-family: Arial, sans-serif;
        font-size: 10px;
        font-weight: normal;
        overflow: hidden;
        padding: 2px 5px;
        word-break: normal;
    }

    .tg .tg-0pky {
        border-color: inherit;
        text-align: left;
        vertical-align: top
    }

    .autoAjuste {
        width: 100%;
    }

    .img {
        display: inline-block;
        float: left;
        margin: 1px;
        padding: 1px;
        border: 1px;
    }

    .fondo {
        background-image: url("http://localhost:3000/img/logo.jpg");
        background-repeat: no-repeat;
        background-size: contain;
    }

    @media all {
        div.saltopagina {
            display: none;
        }
    }

    @media print {
        div.saltopagina {
            display: block;
            page-break-before: always;
        }
    }

    .ti {
        border: none;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .ti td {
        border: none;
        font-family: Arial, sans-serif;
        font-size: 10px;
        overflow: hidden;
        padding: 2px 5px;
        word-break: normal;
    }

    /*     .ti tr td:last-child {
        width: 1%;
        white-space: nowrap;
    } */

    .ti th {
        border: none;
        font-family: Arial, sans-serif;
        font-size: 10px;
        font-weight: normal;
        overflow: hidden;
        padding: 2px 5px;
        word-break: normal;
    }

    .ti .tg-0pky {
        border-color: inherit;
        text-align: left;
        vertical-align: top
    }

</style>

<body>
    <div class="container text-center">
        <div class="row borde">
            <table class="tg autoAjuste">
                <thead>
                    <tr>
                        <th class="tg-0pky fondo" rowspan="4"></th>
                        <th class="tg-0pky" rowspan="4">
                            <span style='font-size: 11px'>Arquitectura y Construcción Damariz Fabiola Mujica Muñoz
                                E.I.R.L.</span><br>
                            <span style='font-size: 11px'>Rut: 76.404.687-0.</span><br>
                            <span style='font-size: 11px'>Giro: Construcción de edificios para uso
                                residencial.</span><br>
                            <span style='font-size: 11px'>Dirección: 1 Poniente 1258 501 Edificio Plaza Pte -
                                Talca.</span><br>

                        </th>
                        <th class="tg-0pky" colspan="3"
                            style="font-weight: bold; color:red; font-size: 18px; border-top: solid 2px; border-left: solid 2px; border-right: solid 2px; border-color: red;">
                            <center>R.U.T: 76.404.687-0</center>
                        </th>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="3"
                            style="font-weight: bold; color:red; font-size: 18px; border-left: solid 2px; border-right: solid 2px; border-color: red;">
                            <center>ORDEN DE COMPRA</center>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="3"
                            style="font-weight: bold; color:red; font-size: 18px; border-left: solid 2px; border-right: solid 2px; border-color: red;">
                            <center>{{ $data['carro']['cotizacion']['cotizacion_codigo'] }}</center>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="3"
                            style="font-size: 12px; color:red; border-bottom: solid 2px; border-left: solid 2px; border-right: solid 2px; border-color: red;">
                            <center>Fecha Vigencia: {{ $data['carro']['cotizacion']['cotizacion_fecha_vigencia'] }}
                            </center>
                        </td>
                    </tr>
                    {{-- <tr>
                        <th class="tg-0pky fondo" rowspan="4">

                        </th>
                        <th class="tg-0pky" colspan="2">
                            <p>Arquitectura y Construcción Damariz Fabiola Mujica Muñoz E.I.R.L.</p>
                            <p>Arquitectura y Construcción Damariz Fabiola Mujica Muñoz E.I.R.L.</p>
                            <p>Arquitectura y Construcción Damariz Fabiola Mujica Muñoz E.I.R.L.</p>
                            <p>Arquitectura y Construcción Damariz Fabiola Mujica Muñoz E.I.R.L.</p>
                        </th>
                        <th class="tg-0pky" colspan="2"
                            style="font-weight: bold; color:red; font-size: 18px; border-top: solid 1px; border-left: solid 1px; border-right: solid 1px; border-color: red;">
                            <center>R.U.T: 76.404.687-0</center>
                        </th>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="2"></td>
                        <td class="tg-0pky" colspan="2"
                            style="font-weight: bold; color:red; font-size: 18px; border-left: solid 1px; border-right: solid 1px; border-color: red;">
                            <center>SOLICITUD MATERIALES</center>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="2"></td>
                        <td class="tg-0pky" colspan="2"
                            style="font-weight: bold; color:red; font-size: 18px; border-left: solid 1px; border-right: solid 1px; border-color: red;">
                            <center>{{ $data['carro']['solicitud']['solicitud_codigo'] }}</center>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="2"></td>
                        <td class="tg-0pky" colspan="2"
                            style="font-size: 12px; color:red; border-bottom: solid 1px; border-left: solid 1px; border-right: solid 1px; border-color: red;">
                            <center>Fecha: {{ $data['carro']['fecha'] }}</center>
                        </td>
                    </tr> --}}

                </thead>
            </table>
            {{-- <img class='img' src='{{ public_path() . '/logo.jpg' }}' height="75px" />
            --}}
            {{-- <table class="noTable">
                <tbody class="noTable">
                    <tr>
                        <td width="30%">
                            <img class='logoLeft' src='{{ public_path() . '/logo.jpg' }}' height="75px" />
                        </td>
                        <td width="50%" class="center">
                            <span class="bold titulo">SOLICITUD DE MATERIALES - N°
                                {{ $data['carro']['solicitud']['solicitud_codigo'] }}</span>
                        </td>
                        <td width="20%">
                            <center>
                                <h6>Fecha: {{ $data['carro']['fecha'] }} </h6>
                            </center>
                        </td>
                    </tr>
                </tbody>
            </table> --}}
            <span class="">
                <h3>SOLICITUD</h3>
            </span>
            <table width="50%" class="ti">
                <tbody width="50%">
                    <tr>
                        <td width="50%">
                            <span class="bold">Tipo Solicitud:</span>
                        </td>
                        <td width="50%">
                            <span>{{ $data['carro']['solicitud']['tipo_solicitud']['ts_nombre'] }} -
                                {{ $data['carro']['solicitud']['tipo_solicitud']['ts_descripcion'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span class="bold">Nombre Solicitud:</span>
                        </td>
                        <td width="50%">
                            <span>{{ $data['carro']['solicitud']['solicitud_nombre'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span class="bold">Descripción Solicitud:</span>
                        </td>
                        <td width="50%">
                            <span>{{ $data['carro']['solicitud']['solicitud_descripcion'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span class="bold">Proveedor:</span>
                        </td>
                        <td width="50%">
                            <span>{{ $data['carro']['cotizacion']['proveedor']['proveedor_nombre'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span class="bold">Rut:</span>
                        </td>
                        <td width="50%">
                            <span>{{ $data['carro']['cotizacion']['proveedor']['proveedor_rut'] - $data['carro']['cotizacion']['proveedor']['proveedor_dv'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span class="bold">Giro:</span>
                        </td>
                        <td width="50%">
                            <span>{{ $data['carro']['cotizacion']['proveedor']['proveedor_giro'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span class="bold">Razon social:</span>
                        </td>
                        <td width="50%">
                            <span>{{ $data['carro']['cotizacion']['proveedor']['proveedor_razon_social'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span class="bold">Telefono:</span>
                        </td>
                        <td width="50%">
                            <span>{{ $data['carro']['cotizacion']['proveedor']['proveedor_telefono'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span class="bold">Dirección:</span>
                        </td>
                        <td width="50%">
                            <span>{{ $data['carro']['cotizacion']['proveedor']['proveedor_direccion'] }}</span>
                        </td>
                    </tr>
                    {{-- @if (isset($data['carro']['datos_tipo_solicitud']['cliente']))
                        <tr>
                            <td width="50%">
                                <span class="bold">Cliente:</span>
                            </td>
                            <td width="50%">
                                <span>{{ $data['carro']['datos_tipo_solicitud']['cliente']['cliente_nombre'] }}
                                    {{ $data['carro']['datos_tipo_solicitud']['cliente']['cliente_apellido_paterno'] }}
                                    {{ $data['carro']['datos_tipo_solicitud']['cliente']['cliente_apellido_materno'] }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <span class="bold">Telefono:</span>
                            </td>
                            <td width="50%">
                                <span>{{ $data['carro']['datos_tipo_solicitud']['cliente']['cliente_telefono'] }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <span class="bold">Dirección:</span>
                            </td>
                            <td width="50%">
                                <span>{{ $data['carro']['datos_tipo_solicitud']['cliente']['cliente_direccion'] }}</span>
                            </td>
                        </tr>
                    @endif
                    @if (isset($data['carro']['datos_tipo_solicitud']['proyecto']))
                        <tr>
                            <td width="50%">
                                <span class="bold">Proyecto:</span>
                            </td>
                            <td width="50%">
                                <span>{{ $data['carro']['datos_tipo_solicitud']['proyecto']['proyecto_nombre'] }}
                                    {{ $data['carro']['datos_tipo_solicitud']['proyecto']['proyecto_telefono_ad'] }} -
                                    {{ $data['carro']['datos_tipo_solicitud']['proyecto']['proyecto_descripcion'] }} -
                                    {{ $data['carro']['datos_tipo_solicitud']['proyecto']['proyecto_direccion'] }}</span>
                            </td>
                        </tr>
                    @endif
                    @if (isset($data['carro']['datos_tipo_solicitud']['centro_costo']))
                        <tr>
                            <td width="50%">
                                <span class="bold">Centro de Costo:</span>
                            </td>
                            <td width="50%">
                                <span>{{ $data['carro']['datos_tipo_solicitud']['centro_costo']['cc_nombre'] }}
                                    -
                                    {{ $data['carro']['datos_tipo_solicitud']['centro_costo']['cc_direccion'] }}</span>
                            </td>
                        </tr>
                    @endif --}}
                </tbody>
            </table>
            <br>
            <span>
                <h3 class="mt">DETALLE</h3>
            </span>
            <table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Material</th>
                        <th>Descripción</th>
                        <th>Unidad</th>
                        <th>Precio U.</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data['carro']['datos_producto'] as $key => $producto)

                        {{-- <tr style="page-break-inside: avoid;">
                            <td>
                                <center>{{ $key + 1 }}</center>
                            </td>
                            <td>
                                <span>{{ $catalogo['catalogo']['catalogo_material'] }}</span>
                            </td>
                            <td>
                                <span>{{ $catalogo['catalogo']['catalogo_descripcion'] }}</span>
                            </td>
                            <td>
                                <span>{{ $catalogo['catalogo']['unidad']['unidad_nombre'] }}</span>
                            </td>
                        </tr> --}}

                        <tr>
                            <td>
                                <center>{{ $key + 1 }}</center>
                            </td>
                            <td>
                                <span>{{ $producto['producto']['producto_material'] }}</span>
                            </td>
                            <td>
                                <span>{{ $producto['producto']['producto_descripcion'] }}</span>
                            </td>
                            <td>
                                <span>
                                    <center>{{ $producto['producto']['unidad']['unidad_nombre'] }}</center>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <center>{{ number_format($producto['cp_precio'], 2, ",", ".") }}</center>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <center>{{ number_format($producto['cp_cantidad'], NULL, ",", ".") }}</center>
                                </span>
                            </td>
                            <td style='text-align: right;'>
                                <span>
                                    {{ number_format($producto['cp_total'], NULL, ",", ".") }}
                                </span>
                            </td>
                        </tr>

                    @endforeach

                </tbody>
                </br>
                <tfoot style=' border-style: none;
                border: 1px solid black;'>

                    <tr>

                        <td style="font-weight: bold; padding-top: 24px; font-size: 12px; text-align: right;" colspan="5">NETO</td>
                        <td style="font-size: 12px;  padding-top: 24px; text-align: right; border: hidden; " colspan="1">$</td>
                        <td style="font-size: 12px;  padding-top: 24px; text-align: right; border: hidden; " colspan="1">
                            <span>{{ $data['carro']['neto']}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding-top: 24px; font-size: 12px; border: hidden; text-align: right;" colspan="5">IVA</td>
                        <td style="font-size: 12px;  padding-top: 24px; text-align: right; border: hidden; " colspan="1">$</td>
                        <td style="font-size: 12px;  padding-top: 24px; text-align: right; border: hidden; " colspan="1">
                            <span>{{ $data['carro']['iva']}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; padding-top: 24px; font-size: 12px; border: hidden; text-align: right;padding-bottom: 18px;" colspan="5">TOTAL</td>
                        <td style="font-size: 12px;  padding-top: 24px; text-align: right; border: hidden; padding-bottom: 18px; " colspan="1">$</td>
                        <td style="font-size: 12px;  padding-top: 24px; text-align: right; border: hidden; padding-bottom: 18px;" colspan="1">
                            <span>{{ $data['carro']['total']}}</span>
                        </td>
                    </tr>

                </tfoot>
            </table>
            </br>
        </div>
    </div>
</body>

</html>
