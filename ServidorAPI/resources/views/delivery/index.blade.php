<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Disponibilidad</title>
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

        socket.on('disponibilidad-delivery:Shipper\\Events\\EventDisponibilidadDelivery', function (data) {
            console.log(data);
            $( "#messages" ).prepend( "<p>&gt;&gt; <b>"+data.usuario.nombres+" ("+data.usuario._id+"):</b> ha cambiado su estado a "+(data.usuario.disponible? 'Disponible' : 'No Disponible')+"</p>" );
        });
    </script>
</body>
</html>