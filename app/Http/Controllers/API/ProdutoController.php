<?php

namespace App\Http\Controllers\API;

use App\models\Produto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProdutoResource;

class ProdutoController extends Controller
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
        return ProdutoResource::collection(Produto::where('estado', '=', 1)->orderBy('id', 'desc')->get());
    }

    public function findProduto()
    {
        if ($search = \Request::get('query')) {
            return ProdutoResource::collection(
                Produto::where('nome', 'LIKE', "%$search%")
                    ->where(function ($query) {
                        $query->where('estado', '=', 1);
                    })
                    ->orderBy('id', 'desc')->get()
            );
        } else {
            return ProdutoResource::collection(Produto::where('estado', '=', 1)->orderBy('id', 'desc')->get());
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
                'quantidade' => 'required|numeric',
                'unidade_medida' => 'required|numeric',
                'preco' => 'required|numeric',
            ]
        );

        return Produto::create([
            'nome' => $request->input('nome'),
            'quantidade' => $request->input('quantidade'),
            'unidade_medida' => $request->input('unidade_medida'),
            'preco' => $request->input('preco'),
            'user_id' => Auth::user()->id,
            'estado' => 1
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
    public function update(Request $request, Produto $produto)
    {
        $produto = Produto::findOrFail($request->id);

        $this->validate($request, [
            'nome' => 'required|max:250',
            'quantidade' => 'required|numeric',
            'unidade_medida' => 'required|numeric',
            'preco' => 'required|numeric',
        ]);

        $produto->update($request->all());

        if ($produto)
            return ['message', 'Dados Produto atualizado com sucesso'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produtoUpdate = Produto::where('id', $id)->update([
            'estado' => -1,
        ]);

        if ($produtoUpdate) {
            return ['message', 'Produto delete sucessfully'];
        }
    }
}
