@extends('layouts.app')
  
@section('title', 'Dashboard - Monitoring Tilikebon')
  
@section('contents')
  <div class="container">
  <h1>MQTT Real-Time Temperature Data</h1>
    
    <!-- Tempat untuk menampilkan data secara teks -->
    <div id="mqtt-data"></div>
    
    <!-- Tempat untuk menampilkan chart suhu -->
    <div class="recent-report__chart">
        <canvas id="temperature-chart"></canvas>
    </div>

    @vite('resources/js/app.js')

    <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            // Inisialisasi grafik
            var ctx = document.getElementById('temperature-chart').getContext('2d');
            var temperatureChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [], // Label untuk sumbu x
                    datasets: [{
                        label: 'Temperature (°C)',
                        data: [],
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Temperature (°C)'
                            }
                        }
                    }
                }
            });

            // Listen for temperature updates via WebSocket
            Echo.channel('mqtt-channel').listen('MessageReceived', (e) => {
                // Menampilkan data suhu dalam bentuk teks
                document.getElementById('mqtt-data').innerText = `Current Temperature: ${e.message} °C`;

                // Dapatkan waktu saat ini untuk label
                var currentTime = new Date().toLocaleTimeString();
                
                // Tambahkan data baru ke grafik
                temperatureChart.data.labels.push(currentTime);
                temperatureChart.data.datasets[0].data.push(parseFloat(e.message));

                // Batasi jumlah data yang ditampilkan (misalnya 10)
                if (temperatureChart.data.labels.length > 10) {
                    temperatureChart.data.labels.shift();
                    temperatureChart.data.datasets[0].data.shift();
                }

                // Update grafik
                temperatureChart.update();
            });
        });
    </script>

    <div class="row">
            <div class="col-md-6">
                <h3>Relay</h3>
                <a href="{{ url('/relay/on') }}" class="btn btn-success">Turn On</a>
                <a href="{{ url('/relay/off') }}" class="btn btn-danger">Turn Off</a>
            </div>
        </div>
      </div>
@endsection