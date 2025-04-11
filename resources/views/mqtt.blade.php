<!DOCTYPE html>
<html>
<head>
    <title>MQTT Real-Time Data</title>
</head>
<body>
    <h1>MQTT Real-Time Data</h1>
    <div id="mqtt-data"></div>

    @vite('resources/js/app.js')
        <script>
            document.addEventListener("DOMContentLoaded", function(event) { 
               Echo.channel('mqtt-channel').listen('MessageReceived', (e) => {
                document.getElementById('mqtt-data').innerText = e.message;
               })
            });
        </script>
    
</body>
</html>