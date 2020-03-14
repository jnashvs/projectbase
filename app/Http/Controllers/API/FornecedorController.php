<?php
namespace App\Http\Controllers\API;

use App\models\Fornecedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\FornecedorResource;

class FornecedorController extends Controller
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
        return FornecedorResource::collection(Fornecedor::where('estado', '=', 1)->orderBy('id', 'desc')->get());
    }

    public function findfornecedor()
    {
        if ($search = \Request::get('query')) {
            return FornecedorResource::collection(
                Fornecedor::where('nome', 'LIKE', "%$search%")
                ->where(function ($query) {
                    $query->where('estado', '=', 1);
                })
                ->orderBy('id', 'desc')->get()
            );
        } else {
            return FornecedorResource::collection(Fornecedor::where('estado', '=', 1)->orderBy('id', 'desc')->get());
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
                'email' => 'sometimes|email',
                'telefone' => 'required|numeric'
            ]
        );

        return Fornecedor::create([
            'nome' => $request->input('nome'),
            'morada' => $request->input('morada'),
            'telefone' => $request->input('telefone'),
            'email' => $request->input('email'),
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
    public function update(Request $request, Fornecedor $fornecedor)
    {
        $fornecedor = Fornecedor::findOrFail($request->id);
        $this->validate($request, [
            'nome' => 'required|max:250',
            'morada' => 'max:250',
            'email' => 'sometimes|email',
            'telefone' => 'required|numeric'
        ]);

        $fornecedor->update($request->all());

        if ($fornecedor)
            return ['message', 'Dados Fornecedor atualizado com sucesso'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fornecedorUpdate = Fornecedor::where('id', $id)->update([
            'estado' => -1,
        ]);

        if ($fornecedorUpdate) {

            return ['message', 'Fornecedor delete sucessfully'];
        }
    }
}



