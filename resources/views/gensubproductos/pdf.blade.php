<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Gestión de Residuos - Reporte</title>

    <style>
        /* Configuración de la página */
        @page {
            margin: 1cm;
            /* Márgenes generales */
        }

        /* Estilo general del cuerpo */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: justify;
        }

        /* Contenedor principal */
        .container {
            width: 100%;
            text-align: center;
            box-sizing: border-box;
            max-width: 100%;
            /* Asegura que no se desborde */
        }

        /* Estilo de la cabecera */
        .header {
            background-color: #611232;
            color: white;
            padding: 15pt;
            margin: -1cm -1cm 10pt -1cm;
            /* Ajuste de márgenes para que no se desborde */
            text-align: center;
        }

        .logo {
            width: 60pt;
            height: auto;
            margin-bottom: 5pt;
        }

        .title {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1pt;
            color: white;
        }

        /* Sección de contenido */
        .section {
            margin-bottom: 20pt;
            border-radius: 8pt;
            padding: 15pt;
            box-shadow: 0 3pt 5pt rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 10pt;
            color: black;
            border-bottom: 1pt solid #611232;
            padding-bottom: 5pt;
        }

        /* Tablas de datos */
        .data-grid,
        .subproduct-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15pt;
            font-size: 9pt;
        }

        .data-grid th,
        .data-grid td,
        .subproduct-table th,
        .subproduct-table td {
            padding: 8pt;
            text-align: left;
            border: 0.5pt solid #ddd;
        }

        .data-grid tr:nth-child(even),
        .subproduct-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .data-label {
            font-weight: bold;
        }

        .subproduct-table th {
            background-color: #611232;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        .highlight {
            font-weight: bold;
            color: #cc0303;
        }

        /* Estilo para el pie de página */
        .footer {
            position: running(footer);
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #666;
            border-top: 0.5pt solid #611232;
            padding-top: 5pt;
        }

        @page {
            @bottom-center {
                content: element(footer);
            }
        }

        /* Saltos de página */
        .page-break {
            page-break-after: always;
        }

        /* Asegura que el contenido de las tablas no se desborde */
        .subproduct-table td,
        .subproduct-table th {
            max-width: 150px;
            /* Ajustar el ancho máximo de las celdas */
            word-wrap: break-word;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="header">
            {{-- <img class="logo" src="{{ $image }}" alt="itsvalogo"> --}}
            <h1 class="title">Gestión de residuos sólidos institucionales</h1>
        </div>

        <div class="section">
            <h2 class="section-title">Resumen de Datos Generados</h2>
            <table class="data-grid">
                <tr>
                    <td class="data-label">Fecha inicio:</td>
                    <td>{{ $inicio->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="data-label">Fecha final:</td>
                    <td>{{ $final->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="data-label">Total generado de subproductos:</td>
                    <td class="highlight">
                        @php
                            $totalGenerado = $datosAgrupados->flatten()->sum('total_kg');
                        @endphp
                        {{ number_format($totalGenerado, 2) }} kg
                    </td>
                </tr>
                <tr>
                    <td class="data-label">Subproducto con mayor generación:</td>
                    <td class="highlight">
                        @php
                            $subproductoMayor = $datosAgrupados->flatten()->sortByDesc('total_kg')->first();
                        @endphp
                        {{ $subproductoMayor ? $subproductoMayor->subproducto_nombre : 'No disponible' }}
                    </td>
                </tr>
                <tr>
                    <td class="data-label">Instituto:</td>
                    <td>{{ $instituto->nombre }}</td>
                </tr>
            </table>
        </div>

        <div class="page-break"></div>

        <div class="section">
            <h2 class="section-title">Desglose de Datos por Subproducto</h2>
            @foreach ($datosAgrupados as $subproducto => $datos)
                <table class="subproduct-table">
                    <thead>
                        <tr>
                            <th colspan="7">{{ $subproducto }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Fila de Fechas -->
                        @php
                            $fechaChunks = array_chunk($datos->pluck('fecha')->toArray(), 6);
                            $cantidadChunks = array_chunk($datos->pluck('total_kg')->toArray(), 6);
                        @endphp
                        @foreach ($fechaChunks as $index => $fechaChunk)
                            <tr>
                                <td class="data-label">Fecha:</td>
                                @foreach ($fechaChunk as $fecha)
                                    <td class="py-3 px-4 text-left">
                                        {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                                    </td>
                                @endforeach
                                <!-- Rellenar celdas vacías si la fila tiene menos de 6 columnas -->
                                @foreach (array_pad($fechaChunk, 6, '') as $fecha)
                                    @if ($fecha === '')
                                        <td class="py-3 px-4 text-left"></td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td class="data-label">Cantidad Generada:</td>
                                @foreach ($cantidadChunks[$index] as $cantidad)
                                    <td class="py-3 px-4 text-left">{{ $cantidad }}</td>
                                @endforeach
                                <!-- Rellenar celdas vacías si la fila tiene menos de 6 columnas -->
                                @foreach (array_pad($cantidadChunks[$index], 6, '') as $cantidad)
                                    @if ($cantidad === '')
                                        <td class="py-3 px-4 text-left"></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>

    <div class="footer">
        <p>Fecha de descarga: {{ now()->format('d/m/Y H:i:s') }} | Página <span class="pagenum"></span></p>
        <p>{{ $instituto->nombre }} - Reporte de Gestión de Residuos</p>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Helvetica");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>

</html>
