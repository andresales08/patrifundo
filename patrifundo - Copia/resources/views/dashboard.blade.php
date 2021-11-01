
    @extends('templates.template')
    
    @section('content')
        <div class="row">
          <div class="col-12">
            <div class="card card-chart">
              <div class="card-header ">
                <div class="row">
                  <div class="col-sm-6 text-left">
                    <h5 class="card-category"></h5>
                    <h2 class="card-title">Data</h2>
                  </div>
                  </div>
                <!-- Form code begins -->
                <form action="">
                @csrf
               
                  <div class="row">
                    <div class="col-sm-6 text-left">
                      <div class="form-group"> <!-- Date input -->
                          <label class="control-label" for="dataInicio">Início</label>
                          <input type="text" id="dataInicio" name="dataInicio" class="calendario form-control date" placeholder="DD/MM/YYYY"  value='@php if(!empty($dataInicio)) echo $dataInicio; @endphp' autocomplete="off"/>
                      </div>
                    </div>
                    <div class="col-sm-6 text-left">
                      <div class="form-group"> <!-- Date input -->
                          <label class="control-label" for="dataFim">Fim</label>
                          <input type="text" id="dataFim" name="dataFim" class="calendario form-control date" placeholder="DD/MM/YYYY"  value='@php if(!empty($dataFim)) echo $dataFim; @endphp' autocomplete="off"/>

                      </div>
                    </div>
                    <div class="col-sm-12 text-center">
                      <div class="form-group"> <!-- Submit button -->
                          <button class="btn btn-primary " name="submit" type="submit">Filtrar</button>
                      </div>
                    </div>
                  </div>
                </form>
                <!-- Form code ends --> 

                </div>
             </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card card-chart">
              <div class="card-header ">
                <div class="row">
                  <div class="col-sm-6 text-left">
                    <h5 class="card-category">Últimos 7 dias</h5>
                    <h2 class="card-title">Patrimônios</h2>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <canvas id="line-chart" width="800" height="450"></canvas>
              </div>
            </div>
          </div>
        </div>

      </div>
      <script>
            new Chart(document.getElementById("line-chart"), {
            type: 'line',
            data: {
                labels: [
                  @foreach( array_reverse($patrimonios) as $patrimonio)
                   "{{date('d/m/Y', strtotime($patrimonio->date))}} ",
                  @endforeach
                      ],
                datasets: [{ 
                    data: [ 
                      @foreach( array_reverse($patrimonios) as $patrimonio)
                      "{{$patrimonio->fundo_value_1}}",
                      @endforeach
                     ],
                    label: "Fundo 1",
                    borderColor: "#3e95cd",
                    fill: false
                }, { 
                    data: [ 
                      @foreach( array_reverse($patrimonios) as $patrimonio)
                      "{{$patrimonio->fundo_value_2}}",
                      @endforeach
                     ],
                    label: "Fundo 2",
                    borderColor: "#c45850",
                    fill: false
                }, { 
                    data: [ 
                      @foreach( array_reverse($patrimonios) as $patrimonio)
                      "{{$patrimonio->fundo_value_3}}",
                      @endforeach
                     ],
                    label: "Fundo 3",
                    borderColor: "#3cba9f",
                    fill: false
                }, {
                    data: [ 
                      @foreach( array_reverse($patrimonios) as $patrimonio)
                      "{{$patrimonio->fundo_value_4}}",
                      @endforeach
                     ],
                    label: "Fundo 4",
                    borderColor: "#e8c3b9",
                    fill: false
                }
                ]
            },
            options: {
              tooltips: {
                displayColors: false,
                callbacks: {
                  label: function(tooltipItem, data) {
                      var label = data.datasets[tooltipItem.datasetIndex].label || '';

                      if (label) {
                          label += ': ';
                      }
                      label += tooltipItem.yLabel.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                      return label;
                    }
                }
              },
              scales: {
                  yAxes: [{
                      ticks: {
                          // Abreviação
                          callback: function(value) {
                            if (value >= 1000000000000 || value <= -1000000000000 ) {
                              return value / 1e12 + 'Tri';
                            } else if (value >= 1000000000 || value <= -1000000000) {
                              return value / 1e9 + 'Bi';
                            } else if (value >= 1000000 || value <= -1000000) {
                              return value / 1e6 + 'Mi';
                            } else  if (value >= 1000 || value <= -1000) {
                              return value / 1e3 + 'Mil';
                            }
                            return value;
                          }
                      }
                  }]
              }
            }
           });
        </script>
      
    @endsection