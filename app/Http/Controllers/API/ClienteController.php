<?php

namespace App\Http\Controllers\API;

use App\models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ClienteResource;

class ClienteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return ClienteResource::collection(Cliente::where('estado', '=', 1)->orderBy('id', 'desc')->get());
        //return Cliente::where('estado', '=', 1)->orderBy('id', 'desc')->paginate(5);
    }

    public function findCliente()
    {
        if ($search = \Request::get('q')) {
            return Cliente::where('nome', 'LIKE', "%$search%")
                ->orderBy('id', 'desc')->paginate(5);
        } else {
            return Cliente::where('estado', '=', 1)->orderBy('id', 'desc')->paginate(5);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'nome' => 'required|max:250',
                'morada' => 'max:250',
                'veiculo' => 'required|max:250',
                'email' => 'sometimes|email',
                'telefone' => 'required|numeric'
            ]
        );

        return Cliente::create([
            'nome' => $request->input('nome'),
            'morada' => $request->input('morada'),
            'telefone' => $request->input('telefone'),
            'veiculo' => $request->input('veiculo'),
            'email' => $request->input('email'),
            'user_id' => 1,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $cliente = Cliente::findOrFail($request->id);
        $this->validate($request, [
            'nome' => 'required|max:250',
            'morada' => 'max:250',
            'veiculo' => 'required|max:50',
            'email' => 'sometimes|email',
            'telefone' => 'required|numeric'
        ]);

        $cliente->update($request->all());

        if ($cliente)
            return ['message', 'Dados Cliente atualizado com sucesso'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clienteUpdate = Cliente::where('id', $id)->update([
            'estado' => -1,
        ]);

        if ($clienteUpdate) {

            return ['message', 'Cliente delete sucessfully'];
        }
    }
}
