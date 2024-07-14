<!DOCTYPE html>
<html>
<head>
    
    <title>Factura</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        table.border {
            border-collapse: collapse;
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
                <div class="vertical-center">
                  <img src="img/logo.svg" alt="Logo" style="width: 100px; height: auto; display: block; margin: auto;">
                </div>
            </td>
            <td style="width:42%" align="center" valign="top">
                <table>
                    <tr><td align="center"><h5 style="margin:0px"><font face="arial">PIZZERÍA ANDREWS</font></h5></td></tr>
                    <tr><td align="center"><h6 style="margin:0px"><font face="arial">CASA MATRIZ</font></h6></td></tr>
                    <tr><td align="center"><h6 style="margin:0px"><font face="arial">CALLE 6 DE OCTUBRE ENTRE CALLE JUNIN Y ADOLFO MIER<br />Nro. 1000</font></h6></td></tr>
                    <tr><td align="center"><h6 style="margin:0px"><font face="arial">Zona/Barrio: CENTRAL</font></h6></td></tr>
                    <tr><td align="center"><h6 style="margin:0px"><font face="arial">Telefono: 252786</font></h6></td></tr>
                    <tr><td align="center"><h6 style="margin:0px"><font face="arial">Oruro - Bolivia</font></h6></td></tr>
                </table>
            </td>
            <td style="width:29%">
                <table class="border" style="width:100%">
                    <tr><td align="center"><h5 style="margin:0px"><font face="arial">NIT: 3073695019</font></h5></td></tr>
                    <tr><td align="center" style="background-color:#D8D8D8"><h5 style="margin:0px"><font face="arial">ORIGINAL***</font></h5></td></tr>
                    <tr><td align="center"><h5 style="margin:0px"><font face="arial">Nro. Factura: {{$numero}}</font></h5></td></tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="3" height="20"></td></tr>
        <tr><td colspan="3" align="center"><h4 style="margin:0px"><font face="arial">FACTURA</font></h4></td></tr>
        <tr><td colspan="3" align="center"><h6 style="margin:0px"><font face="arial">(Con derecho a Crédito Fiscal)</font></h6></td></tr>
        <tr><td colspan="3" height="20"></td></tr>
        <tr>
            <td colspan="3">
                <table style="width:100%">
                    <tr>
                        <td style="width:20%"><font face="arial"><h5 style="margin:0px">Lugar y Fecha: </h5></font></td>
                        <td style="width:80%;border-bottom:1px solid black"><font face="arial" size="2">Oruro - Bolivia {{now()}}</font></td>
                    </tr>
                </table>
                <table style="width:100%">
                    <tr>
                        <td style="width:20%"><font face="arial"><h5 style="margin: 0px">Señor(es): </h5></font></td>
                        <td style="width:80%;border-bottom:1px solid black"><font face="arial" size="2" class="uppercase">{{$pedido->client->apellidos. " ".$pedido->client->nombres}}</font></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="3" height="10"></td></tr>
        <tr>
            <td colspan="3">
                <table class="border" style="width:100%;">
                    <thead>
                        <tr style="background-color:#D8D8D8">
                            <th style="width:7%"><font face="arial Narrow" size="3">Cant. </font></th>
                            <th style="width:49%"><font face="arial Narrow" size="3">Descripcion</font></th>
                            <th style="width:22%"><font face="arial Narrow" size="3">Pre. Unitario</font></th>
                            <th style="width:22%"><font face="arial Narrow" size="3">Subtotal</font></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedido->productos as $producto)
                            <tr>
                                <td class="centrado" style="width:7%"><font face="arial Narrow" size="3"  >{{$producto->pivot->cantidad}}</font></td>
                                <td class="centrado" style="width:49%"><font face="arial Narrow" size="3" >{{$producto->nombre}}</font></td>
                                <td class="centrado" style="width:22%"><font face="arial Narrow" size="3" >{{$producto->precio}}</font></td>
                                <td class="centrado" style="width:22%"><font face="arial Narrow" size="3" >{{$producto->pivot->cantidad*$producto->precio}}</font></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="border: 0px !important"></td>
                            <td style="border: 0px !important"></td>
                            <td align="right"><font face="arial" size="2">TOTAL: </font></td>
                            <td class="centrado"  align="right"><font face="arial" size="2">{{$subtotal}}</font></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="row" colspan="4" align="left"><font face="arial" size="2">Son: {{$subtotalEnPalabras}}</font></th>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
        <tr><td colspan="4" align="left"><font face="arial" size="1">USUARIO: {{Auth::user()->nombres}}</font></td></tr>
        <tr><td colspan="4" align="center"><font face="arial" size="1">"ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAIS, EL USO ILICITO DE ESTA SERA SANCIONADO DE ACUERDO A LEY"</font></td></tr>
        <tr><td colspan="4" align="center"><font face="arial" size="1">Ley N° 453: El proveedor debe brindar atención sin discriminación, con respeto y cordialidad a los usuarios y consumidores</font></td></tr>
        <tr><td colspan="4" align="left"><font face="arial" size="1"><br /><br />*** La presente factura aun no tiene número de autorización, por lo que solo es para ILUSTRACION</font></td></tr>
    </table>
</body>
</html>
