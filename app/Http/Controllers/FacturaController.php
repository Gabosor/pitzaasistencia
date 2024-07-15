<?php
namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Factura;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use NumberToWords\NumberToWords;

class FacturaController extends Controller
{
    public function generarPDF($id)
    {
        $pedido = Pedido::with('productos')->findOrFail($id);
        $facturaExistente = Factura::where('pedido_id', $pedido->id)->first();
        if ($facturaExistente) {
            return redirect()->back()->with('error', 'La factura para este pedido ya ha sido impresa.');
        }
        $subtotal = $pedido->productos->reduce(function ($carry, $producto) {
            return $carry + ($producto->precio * $producto->pivot->cantidad);
        }, 0);

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('es');

        $entero = floor($subtotal);
        $centavos = round(($subtotal - $entero) * 100);

        $enteroEnPalabras = ucfirst($numberTransformer->toWords($entero));
        $centavosEnNumeros = str_pad($centavos, 2, '0', STR_PAD_LEFT);

        $subtotalEnPalabras = "{$enteroEnPalabras} {$centavosEnNumeros}/100 bolivianos";
        $subtotalEnPalabras = ucfirst($subtotalEnPalabras);

        $ultimoNumero = Factura::max('numero') ?? 0;
        $nuevoNumero = $ultimoNumero + 1;

        $pdf = PDF::loadView('factura', [
            'pedido' => $pedido,
            'subtotal' => $subtotal,
            'subtotalEnPalabras' => $subtotalEnPalabras,
            'numero' => $nuevoNumero
        ]);

        Factura::create([
            'pedido_id' => $pedido->id,
            'user_id' => auth()->user()->id,
            'client_id' => $pedido->client_id,
            'total' => $subtotal,
            'numero' => $nuevoNumero,
        ]);

        return $pdf->stream('factura_'.$pedido->id.'.pdf');
    }
}
