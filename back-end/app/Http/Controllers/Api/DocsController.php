<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DocsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Doc::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //VALIDA SE É CNPJ OU CPF E SÓ PERMITE 1 UNICO CADASTRO DO MESMO NUMERO DE DOCUMENTO
        $request->validate([
            'number' => 'required|CpfCnpj|unique:docs,number'
        ]);
        return Doc::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($number)
    {
        Validator::make(['number' => 'required'], ['number' => 'CpfCnpj'], ['number' => 'unique:docs,number']);
        return Doc::where('number',$number)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Doc::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //VALIDA SE É CNPJ OU CPF E SÓ PERMITE 1 UNICO CADASTRO DO MESMO NUMERO DE DOCUMENTO
        $request->validate([
            'number' => 'required|CpfCnpj|unique:docs,number'
        ]);
        $doc = Doc::findOrFail($id);
        $doc->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doc = Doc::findOrFail($id);
        $doc->delete();
    }
}
