<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Chat de Shipper</title>
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
</head>
<body>
	<div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2" >
              <div id="messages" ></div>
            </div>
        </div>
    </div>
    <script>
        var socket = io.connect('http://e-cademy.in:1715');       

        socket.on('geoposicion-motociclistas:Shipper\\Events\\EventoCambioUbicacion', function (data) {
            console.log(data);
            $( "#messages" ).prepend( "<p>&gt;&gt; <b>"+data.usuario.nombres+" ("+data.usuario._id+"):</b> ha cambiado su ubicacion: "+data.geoposicion.latitud+" / "+data.geoposicion.longitud+"</p>" );
        });
    </script>
</body>
</html>