
    @extends('templates.template')
    
    @section('content')

    @if ($errors->any())
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

@if ($message = Session::get('success'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p>{{ $message }}</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
        </div>
    </div>
@endif

@if ($message = Session::get('danger'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p>{{ $message }}</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
        </div>
    </div>
@endif
    
@if( request()->segment(2) == 'create')
    <div class="row">
        <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Inserir</h4>
              </div>
              <div class="card-body">
                <form name="formEdit" action="{{ route('patrimonios.store') }}"  method="POST">
                    @csrf
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fundo 1</label>
                            <input type="text" class="form-control  money" id="fundo1" name="fundo1" placeholder=" Valor">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fundo 2</label>
                            <input type="text" class="form-control  money" id="fundo2" name="fundo2" placeholder=" Valor">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fundo 3</label>
                            <input type="text" class="form-control  money" id="fundo3" name="fundo3" placeholder=" Valor">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fundo 4</label>
                            <input type="text" class="form-control  money" id="fundo4" name="fundo4" placeholder=" Valor">
                        </div>
                    </div>
                </div>
                
                <div class="row text-center">
                    <div class="col-sm-4 col-lg-2 col-md-2 mx-auto">
                        <label for="exampleInputEmail1">Data</label>
                        <input type="text" id="date" name="date" class="calendario form-control date" placeholder="DD/MM/YYYY"  autocomplete="off" />

                    </div>
                    <div class="col-12">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
                </form>
              </div>
            </div>
          </div>
      </div>
    @endif

    
@if( request()->segment(2) == 'edit')
    <div class="row">
        <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Editar</h4>
              </div>
              <div class="card-body">
                <form name="formEdit" method="post" action="{{ route('patrimonios.update', $editaPatrimonio->id ) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="valorPatrimonio">Fundo {{$editaPatrimonio->fundo_id}}</label> 
                        <input type="text" class="form-control money" id="valorPatrimonio" name="valorPatrimonio" value="{{ number_format($editaPatrimonio->value, 2, ',', '.') }}">
                    </div>

                    <button id="botaoEditar" type="submit" class="btn btn-warning ">Editar</button>
                </form>
              </div>
            </div>
          </div>
      </div>
    @endif


        <div class="row">
          <div class="col-12">
            <div class="card card-chart">
              <div class="card-header ">
                @if( request()->segment(2) != 'create')
                <div class="row">
                    <div class="col-12 ml-auto mr-auto text-center">
                        <a href="{{ route('patrimonios.create') }}" class="btn btn-success btn-block" style="max-width:300px;margin:auto;">Incluir Patrimônio</a>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-sm-6 text-left">
                        <h5 class="card-category">Últimos 7 dias</h5>
                        <h2 class="card-title">Patrimônios</h2>
                    </div>
                </div>
              </div>
              <div class="card-body">


              <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th style="color:#3e95cd !important;">Fundo 1</th>
                        <th style="color:#c45850 !important;">Fundo 2</th>
                        <th style="color:#3cba9f !important;">Fundo 3</th>
                        <th style="color:#e8c3b9 !important;">Fundo 4</th>
                    </tr>
                </thead>
                <tbody>
                @csrf
                    @php
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    @endphp
                    @foreach($patrimonios as $patrimonio)
                    <tr>
                        <td>
                            <form action="{{ route('patrimonios.destroy', date('Y-m-d', strtotime($patrimonio->date)) )}}" method="POST" onsubmit="return confirm('Você tem certeza que deseja deletar?');"> 
                                @csrf
                                @method('DELETE')
                                <button type="submit" rel="tooltip" title="Deletar" class="btn btn-link warning-del" style="color:#c23839;font-weight: normal;"> <i class="tim-icons icon-trash-simple"></i></button>
                            </form>
                        </td>
                        <td>
                            {{ date('d/m/Y', strtotime($patrimonio->date))}}
                        </td>
                        <td style="color:#3e95cd !important;">
                        <a href="{{ url('patrimonio/edit/' . $patrimonio->fundo_id_1)}}" rel="tooltip" title="Editar" class="btn btn-link" style="color:#3e95cd;font-weight: normal;">
                        {{ "R$ " . number_format($patrimonio->fundo_value_1, 2, ',', '.') }}
                        <i class="tim-icons icon-pencil"></i>  </a></td>
                        <td style="color:#c45850 !important;">
                        <a href="{{ url('patrimonio/edit/' . $patrimonio->fundo_id_2)}}" rel="tooltip" title="Editar" class="btn btn-link" style="color:#c45850;font-weight: normal;">
                        {{ "R$ " . number_format($patrimonio->fundo_value_2, 2, ',', '.') }}
                        <i class="tim-icons icon-pencil"></i>  </a></td>
                        <td style="color:#3cba9f !important;">
                        <a  href="{{ url('patrimonio/edit/' . $patrimonio->fundo_id_3)}}" rel="tooltip" title="Editar" class="btn btn-link" style="color:#3cba9f;font-weight: normal;" >
                        {{ "R$ " . number_format($patrimonio->fundo_value_3, 2, ',', '.') }}
                        <i class="tim-icons icon-pencil" ></i>  </a></td>
                        <td style="color:#e8c3b9 !important;">
                        <a href="{{ url('patrimonio/edit/' . $patrimonio->fundo_id_4)}}" rel="tooltip" title="Editar" class="btn btn-link" style="color:#e8c3b9;font-weight: normal;">
                        {{ "R$ " . number_format($patrimonio->fundo_value_4, 2, ',', '.') }}
                        <i class="tim-icons icon-pencil"></i>  </a></td>
                    </tr>
                    @endforeach
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th style="color:#3e95cd !important;">Fundo 1</th>
                        <th style="color:#c45850 !important;">Fundo 2</th>
                        <th style="color:#3cba9f !important;">Fundo 3</th>
                        <th style="color:#e8c3b9 !important;">Fundo 4</th>
                    </tr>
                </tfoot>
            </table>




              </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
      $('#example').DataTable({
    "columns": [
      { "type": "date-eu" },
      null,
      null,
      null,
      null,
      null
    ]
  });
    });
 </script>
  <script>
    $(document).ready(function(){
      var date_input=$('input[name="date"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'mm/dd/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
    })
</script>
      
    @endsection