<?php

namespace App\Http\Controllers\API;

use App\models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ClienteResource;
use App\Listeners\SendMailCustomer;
use App\Events\CustomerRegistred;
use Illuminate\Notifications\Notification;
use App\User;
use App\Notifications\ClienteCriado;

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
    }

    public function findcliente()
    {
        if ($search = \Request::get('query')) {
            return ClienteResource::collection(
                Cliente::where('nome', 'LIKE', "%$search%")
                    ->where(function ($query) {
                        $query->where('estado', '=', 1);
                    })
                    ->orderBy('id', 'desc')->get()
            );
        } else {
            return ClienteResource::collection(Cliente::where('estado', '=', 1)->orderBy('id', 'desc')->get());
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

        $cliente = Cliente::create([
            'nome' => $request->input('nome'),
            'morada' => $request->input('morada'),
            'telefone' => $request->input('telefone'),
            'veiculo' => $request->input('veiculo'),
            'email' => $request->input('email'),
            'user_id' => Auth::user()->id
        ]);


        if ($cliente) {

            //when o invoke a event the listener´s automaticly executed
            event(new CustomerRegistred($cliente));

            $user = \App\User::find(auth()->user()->id);

            \Notification::send($user, new ClienteCriado($cliente));
            
            return $cliente;
        }
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

        $clienteUpdated = $cliente->update($request->all());

        if ($clienteUpdated) {
            return ['message', 'Cliente updated sucessfully'];
        }
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
