<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelFundos;
use App\Models\ModelPatrimonios;

class PatrimonioController extends Controller
{
    private $objPatrimonio;
    private $objFundo;

    public function __construct()
    {
        $this->objFundo = new ModelFundos();
        $this->objPatrimonio = new ModelPatrimonios();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inicio = null;
        $fim  = null;
        $dataInicio =  $request->dataInicio;
        $dataFim =  $request->dataFim;
        if(!empty($request->dataInicio) && !empty($request->dataFim)){
        $inicio =  \Carbon\Carbon::createFromFormat('d/m/Y', $dataInicio)->format('Y-m-d');
        $fim =  \Carbon\Carbon::createFromFormat('d/m/Y', $dataFim)->format('Y-m-d');
    }
        $patrimonios = $this->objPatrimonio->buscaPatrimonios($inicio,$fim);
       // dd($this->objPatrimonio->datePatrimonios());
       return view('dashboard',compact('patrimonios','dataInicio','dataFim'));
    }

    public function patrimonio()
    {
        $patrimonios = $this->objPatrimonio->datePatrimonios();
        return view('patrimonio',compact('patrimonios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patrimonios = $this->objPatrimonio->datePatrimonios();
        return view('patrimonio',compact('patrimonios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'fundo1' => 'required' ,
            'fundo2' => 'required' ,
            'fundo3' => 'required' ,
            'fundo4' => 'required' ,
            'date' => 'required' ,
        ]);

        $this->objPatrimonio->inserir($request);

        return redirect(url('patrimonio'))
        ->with('success','Patrimônios inserido com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $editaPatrimonio = $this->objPatrimonio::find($id);
       
        $patrimonios = $this->objPatrimonio->datePatrimonios();
        return view('patrimonio',compact('patrimonios','editaPatrimonio'));
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
        $request->valorPatrimonio = str_replace (',', '.',preg_replace('/[^0-9+,]/', '', $request->valorPatrimonio));
        $request->validate([
            'valorPatrimonio' => 'required'
        ]);
        $this->objPatrimonio->where(['id'=>$id])->update([
            'value'=> $request->valorPatrimonio
        ]);
        return redirect(url('patrimonio/edit/'. $id))
        ->with('success','Patrimônios atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($date)
    {
        $patrimonios = $this->objPatrimonio->deletaPatrimonios($date);
        
        return redirect(url('patrimonio'))
        ->with('success','Patrimônios deletado com sucesso.');
    }
}
