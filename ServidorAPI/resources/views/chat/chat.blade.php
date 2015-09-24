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
		<div class="col-lg-8">
            <input type="text" id="lat" class="col-lg-4" placeholder="Latitud">
			<input type="text" id="lng" class="col-lg-4" placeholder="Longitud">
			<input type="hidden" id="tokenCSRF" name="_token" value="{{ csrf_token() }}">
			<input type="button" value="Enviar" onclick="enviar();">
		</div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2" >
              <div id="messages" ></div>
            </div>
        </div>
    </div>
    <script>
        var socket = io.connect('http://e-cademy.in:1715');
        

        socket.on('geolocation-channel:Shipper\\Events\\EventoCambioUbicacion', function (data) {
            console.log(data);
            $( "#messages" ).prepend( "<p>&gt;&gt; <b>Nueva posición:</b> Latitud "+data.posicion.lat+" - Longitud "+ data.posicion.lng+"</p>" );
        });


        $(document).ready(function() {
        	$('#mensaje').bind('keypress', function(e) {
        		var code = e.keyCode || e.which;
				if(code == 13) { //Enter keycode
					enviar();
				}
        	});
        });

        function enviar(){
            var latitud = $('#lat').val();
    		var longitud = $('#lng').val();
    		if (latitud && longitud) {
    			$.ajax({
    				url: '/location',
    				type: 'POST',
    				dataType: 'json',
    				data: {
                        lat: latitud,
    					lng: longitud,
    					_token: $('#tokenCSRF').val()
    				},
    			})
    			.done(function(data) {
    				console.log("success");
    				console.log(data);
    			})
    			.fail(function(error) {
    				alert('Mensaje no enviado');
    				console.log("error");
    				console.log(error);
    			})
    			.always(function(){
    				$('#mensaje').val('');
    			});
    			
    		};
    	}
    </script>
</body>
</html>