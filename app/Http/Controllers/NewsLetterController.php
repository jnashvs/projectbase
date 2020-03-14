<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;


class NewsLetterController extends Controller
{
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
}
