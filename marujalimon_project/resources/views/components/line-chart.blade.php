


@push('scripts')

<script src="{{ asset('/tabla/assets/plugins/chart.umd.js') }}"></script>
<script src="{{ asset('/js/graficos/chart-js.demo.js') }}"></script>
<script src="{{ asset('/js/graficos/highlight.min.js') }}"></script>
<script src="{{ asset('/js/graficos/render.highlight.js') }}"></script>
@endpush


					<div>
						<canvas id="line-chart"></canvas>
					</div>





<script>
    Chart.defaults.color = 'rgba(0, 0, 0, .65)'; // Azul
    Chart.defaults.font.family = 'Arial'; // Cambia la fuente según sea necesario
    Chart.defaults.font.weight = 500;
    Chart.defaults.scale.grid.color = 'rgba(0, 0, 0, .15)'; // Azul
    Chart.defaults.scale.ticks.backdropColor = 'rgba(0, 0, 0, 0)'; // Azul

    var randomScalingFactor = function() {
      return Math.round(Math.random()*100)
    };

    var ctx = document.getElementById('line-chart').getContext('2d');
    var lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
          label: 'Dataset 1',
          borderColor: 'rgba(0, 0, 255, 1)', // Azul
          pointBackgroundColor: 'rgba(0, 0, 255, 1)', // Azul
          pointRadius: 4,
          borderWidth: 2,
          backgroundColor: 'rgba(0, 0, 255, .3)', // Azul
          data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
        }, {
          label: 'Dataset 2',
          borderColor: 'rgba(255, 0, 0, .75)', // Rojo
          pointBackgroundColor: 'rgba(0, 0, 0, 1)', // Puedes ajustar el color de los puntos según sea necesario
          pointRadius: 4,
          borderWidth: 2,
          backgroundColor: 'rgba(255, 0, 0, .5)', // Rojo
          data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
        }]
      }
    });
</script>
