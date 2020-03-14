<?php

namespace App\Http\Controllers\API;

use App\models\Servico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ServicoResource;

class ServicoController extends Controller
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
        return ServicoResource::collection(Servico::where('estado', '=', 1)->orderBy('id', 'desc')->get());
    }

    public function findServico()
    {
        if ($search = \Request::get('query')) {
            return ServicoResource::collection(
                Servico::where('nome', 'LIKE', "%$search%")
                    ->where(function ($query) {
                        $query->where('estado', '=', 1);
                    })
                    ->orderBy('id', 'desc')->get()
            );
        } else {
            return ServicoResource::collection(Servico::where('estado', '=', 1)->orderBy('id', 'desc')->get());
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
                'descricao' => 'max:250',
                'valor' => 'required|numeric'
            ]
        );

        return Servico::create([
            'nome' => $request->input('nome'),
            'tipoveiculo' => $request->input('tipoveiculo'),
            'descricao' => $request->input('descricao'),
            'valor' => $request->input('valor'),
            'user_id' => Auth::user()->id
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
    public function update(Request $request, Servico $servico)
    {
        $Servico = Servico::findOrFail($request->id);
        $this->validate($request, [
            'nome' => 'required|max:250',
            'descricao' => 'max:250',
            'valor' => 'required|numeric'
        ]);

        $servico->update($request->all());

        if ($Servico)
            return ['message', 'Dados Serviço atualizado com sucesso'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servicoUpdate = Servico::where('id', $id)->update([
            'estado' => -1,
        ]);

        if ($servicoUpdate) {
            return ['message', 'Servico delete sucessfully'];
        }
    }
}
