<!DOCTYPE html>
<html>
<head>
    <title>Planilla de Sueldos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        table.border {
            border-collapse: collapse;
            width: 100%;
        }
        table.border th,
        table.border td {
            padding: 5px;
            border: 1px solid black;
        }
        .uppercase {
            text-transform: uppercase;
        }
        .centrado {
            text-align: center;
        }
    </style>
</head>
<body>
    <table style="width:100%">
        <tr>
            <td style="width:29%">

            </td>
            <td style="width:42%" align="center" valign="top">

            </td>
            <td style="width:29%">
                <table class="border" style="width:100%">
                    <tr><td align="center" style="background-color:#D8D8D8"><h5 style="margin:0px"><font face="arial">PLANILLA DE SUELDOS</font></h5></td></tr>
                    <tr><td align="center"><h5 style="margin:0px"><font face="arial">Mes/Año: {{$month}}/{{$year}}</font></h5></td></tr>
                </table>
            </td>
        </tr>
    </table>
    <h4 class="centrado" style="margin:20px 0px"><font face="arial">PLANILLA DE SUELDOS</font></h4>
    <table class="border">
        <thead>
            <tr style="background-color:#D8D8D8">
                <th><font face="arial Narrow" size="3">Nombre</font></th>
                       <th><font face="arial Narrow" size="3">Días Trabajados</font></th>
                <th><font face="arial Narrow" size="3">Días Faltantes</font></th>
                <th><font face="arial Narrow" size="3">Salario Básico</font></th>
                <th><font face="arial Narrow" size="3">Descuentos por Falta</font></th>
                <th><font face="arial Narrow" size="3">Descuento AFP</font></th>
                <th><font face="arial Narrow" size="3">Líquido Pagable</font></th>
         
            </tr>
        </thead>
        <tbody>
            @foreach ($payrollData as $data)
                <tr>
                    <td class="centrado"><font face="arial Narrow" size="3">{{ $data['name'] }}</font></td>
                     <td class="centrado"><font face="arial Narrow" size="3">{{ $data['totalDaysWorked'] }}</font></td>
                    <td class="centrado"><font face="arial Narrow" size="3">{{ $data['totalDaysMissed'] }}</font></td>
                    <td class="centrado"><font face="arial Narrow" size="3">{{ number_format($data['totalSalary'], 2) }}</font></td>
                    <td class="centrado"><font face="arial Narrow" size="3">{{ number_format($data['missedDaysPenalty'], 2) }}</font></td>
                    <td class="centrado"><font face="arial Narrow" size="3">{{ number_format($data['afpDiscount'], 2) }}</font></td>
                    <td class="centrado"><font face="arial Narrow" size="3">{{ number_format($data['finalSalary'], 2) }}</font></td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
