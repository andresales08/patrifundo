<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelPatrimonios extends Model
{
    protected $table="patrimonios";
 
    public function inserir($data){
        
        $antigo = array(".", ",");
        $novo   = array("", ".");
        
        $date = \Carbon\Carbon::createFromFormat('d/m/Y', $data['date'])->locale('en');

        for($i=1; $i <= 4 ; $i++){
            DB::table('patrimonios')->insert([
                'date' => $date,
                'fundo_id' => $i,
                'value' => str_replace($antigo, $novo, $data['fundo'.$i]),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }
    public function datePatrimonios()
    {
        $patrimonios = DB::select(
            "SELECT date, 
            max(case when fundo_id = 1  then id END ) as fundo_id_1,
            max(case when fundo_id = 2  then id END ) as fundo_id_2,
            max(case when fundo_id = 3  then id END ) as fundo_id_3,
            max(case when fundo_id = 4  then id END ) as fundo_id_4,
            max(case when fundo_id = 1  then value END ) as fundo_value_1,
            max(case when fundo_id = 2  then value END ) as fundo_value_2,
            max(case when fundo_id = 3  then value END ) as fundo_value_3,
            max(case when fundo_id = 4  then value END ) as fundo_value_4
        
            from patrimonios 
            GROUP BY date"
        );
        return $patrimonios;
    }

    public function buscaPatrimonios($dataInicio = null, $dataFim = null)
    {
        if(is_null($dataInicio)){ $dataInicio = '0000-00-00';}
        if(is_null($dataFim)){ $dataFim = '9999-01-01';}
        $patrimonios = DB::select(
            "SELECT date, 
            max(case when fundo_id = 1  then id END ) as fundo_id_1,
            max(case when fundo_id = 2  then id END ) as fundo_id_2,
            max(case when fundo_id = 3  then id END ) as fundo_id_3,
            max(case when fundo_id = 4  then id END ) as fundo_id_4,
            max(case when fundo_id = 1  then value END ) as fundo_value_1,
            max(case when fundo_id = 2  then value END ) as fundo_value_2,
            max(case when fundo_id = 3  then value END ) as fundo_value_3,
            max(case when fundo_id = 4  then value END ) as fundo_value_4
        
            from patrimonios 
            where Date between '$dataInicio' AND '$dataFim'
            GROUP BY date 
            ORDER BY date
            DESC LIMIT 7"
        );
        return $patrimonios;
    }

    
    public function deletaPatrimonios($date)
    {
        $patrimonios = DB::table('patrimonios')->where('date', $date )->delete();
        
        return $patrimonios;
    }
    
}
