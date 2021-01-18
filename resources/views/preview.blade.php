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
                            <center>SOLICITUD MATERIALES</center>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="3"
                            style="font-weight: bold; color:red; font-size: 18px; border-left: solid 2px; border-right: solid 2px; border-color: red;">
                            <center>{{ $data['carro']['solicitud']['solicitud_codigo'] }}</center>
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-0pky" colspan="3"
                            style="font-size: 12px; color:red; border-bottom: solid 2px; border-left: solid 2px; border-right: solid 2px; border-color: red;">
                            <center>Fecha: {{ $data['carro']['fecha'] }}</center>
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
            <table width="50%" class="">
                <tbody width="50%">
                    <tr>
                        <td width="50%">
                            <span>Tipo Solicitud:</span>
                        </td>
                        <td width="50%">
                            <span class="bold">{{ $data['carro']['solicitud_tipo']['ts_nombre'] }} -
                                {{ $data['carro']['solicitud_tipo']['ts_descripcion'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span>Nombre Solicitud:</span>
                        </td>
                        <td width="50%">
                            <span class="bold">{{ $data['carro']['solicitud']['solicitud_nombre'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span>Descripción Solicitud:</span>
                        </td>
                        <td width="50%">
                            <span class="bold">{{ $data['carro']['solicitud']['solicitud_descripcion'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span>Cliente:</span>
                        </td>
                        <td width="50%">
                            <span class="bold">{{ $data['carro']['datos_tipo_solicitud']['cliente']['cliente_nombre'] }}
                                {{ $data['carro']['datos_tipo_solicitud']['cliente']['cliente_apellido_paterno'] }}
                                {{ $data['carro']['datos_tipo_solicitud']['cliente']['cliente_apellido_materno'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span>Telefono:</span>
                        </td>
                        <td width="50%">
                            <span
                                class="bold">{{ $data['carro']['datos_tipo_solicitud']['cliente']['cliente_telefono'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span>Dirección:</span>
                        </td>
                        <td width="50%">
                            <span
                                class="bold">{{ $data['carro']['datos_tipo_solicitud']['cliente']['cliente_direccion'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span>Proyecto:</span>
                        </td>
                        <td width="50%">
                            <span
                                class="bold">{{ $data['carro']['datos_tipo_solicitud']['proyecto']['proyecto_nombre'] }}
                                {{ $data['carro']['datos_tipo_solicitud']['proyecto']['proyecto_telefono_ad'] }} -
                                {{ $data['carro']['datos_tipo_solicitud']['proyecto']['proyecto_descripcion'] }} -
                                {{ $data['carro']['datos_tipo_solicitud']['proyecto']['proyecto_direccion'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <span>Centro de Costo:</span>
                        </td>
                        <td width="50%">
                            <span class="bold">{{ $data['carro']['datos_tipo_solicitud']['centro_costo']['cc_nombre'] }}
                                - {{ $data['carro']['datos_tipo_solicitud']['centro_costo']['cc_direccion'] }}</span>
                        </td>
                    </tr>
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
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data['carro']['datos_catalogo'] as $key => $catalogo)

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
                                    <span>{{ $catalogo['catalogo']['catalogo_material'] }}</span>
                                </td>
                                <td>
                                    <span>{{ $catalogo['catalogo']['catalogo_descripcion'] }}</span>
                                </td>
                                <td>
                                    <span><center>{{ $catalogo['catalogo']['unidad']['unidad_nombre'] }}</center></span>
                                </td>
                                <td>
                                    <span><center>{{ $catalogo['sc_cantidad']}}</center></span>
                                </td>
                            </tr>

                    @endforeach
                </tbody>
            </table>
            </br>
        </div>
    </div>
</body>

</html>
