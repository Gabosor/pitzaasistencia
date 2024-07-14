<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\RegistroRequest;
use App\Http\Resources\ClientCollection;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         return new ClientCollection(Client::all());

    }
    public function register(RegistroRequest $request)
    {
        $data = $request->validated();

        $user = Client::create([
            'ci' => $data['ci'],
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'telefono' => $data['telefono'],
            'email' => $data['email'],
        ]);

        // retornar una respuesta
        return [
            'user' => $user
        ];
    }
    public function search(Request $request)
    {
        $query = $request->get('query');

        $clientes = Client::where('nombres', 'like', "%{$query}%")
            ->orWhere('ci', 'like', "%{$query}%")
            ->get();
        return response()->json($clientes);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function re(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
