<!DOCTYPE html>
<html class=no-js lang="es">

<head>
    <meta charset=utf-8>
    <title>Club RPM</title>
    <meta name=description content="">
    <meta name=viewport content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href=/favicon.b25e58c4.ico>
    <link rel=apple-touch-icon href=/apple-touch-icon.9727d3c2.png>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel=stylesheet href={{ asset( 'styles/vendor.d41d8cd9.css') }}>
    <link rel=stylesheet href={{ asset( 'styles/main.9ff03bce.css') }}>
    <script src={{ asset( 'scripts/vendor/modernizr.1cb556bb.js') }}></script> 

    <body>
		<!--[if lt IE 10]>
		  <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
        <header id=headerTop class="maximoAncho col-lg-12">
        	<nav class="navbar navbar-default visible-xs-block col-xs-12">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class=hvr-underline-from-center><a href="http://clubrpm.pe">Inicio</a></li>
						<li class=hvr-underline-from-center><a href="http://clubrpm.pe/como_jugar">Como Jugar</a></li>
						<li class=hvr-underline-from-center><a href="#">Sobre Nosotros</a></li>
						<li id=btnDescarga class=hvr-grow><a href="">Descargar App</a></li>
					</ul>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
            <a href=http://clubrpm.pe class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            	<img src={{ asset( 'images/logo.1cc10f90.png') }} alt="" class=img-responsive style="width:224px;display:block;margin:auto;">
            </a>
            <nav class="hidden-xs">
				<ul class="nav navbar-nav">
					<li class=hvr-underline-from-center><a href="http://clubrpm.pe">Inicio</a></li>
					<li class=hvr-underline-from-center><a href="http://clubrpm.pe/como_jugar">Como Jugar</a></li>
					<li class=hvr-underline-from-center><a href="#">Sobre Nosotros</a></li>
					<li id=btnDescarga class=hvr-grow><a href="">Descargar App</a></li>
				</ul>
			</nav>
            <div class=clearfix></div>
        </header>
        <div class=clearfix></div>
        <!-- Place somewhere in the <body> of your page -->
        <section id=sliderTop class="maximoAncho flexslider">
            <ul class=slides>
                <li><img src={{ asset( 'images/slide1.0563aec2.png') }} alt=""></li>
                <li><img src={{ asset( 'images/slide2.383f3fbe.png') }} alt=""></li>
            </ul>
        </section>
        <section id=sliderBlue>
            <section id=slideMiddle class="maximoAncho flexslider">
                <ul class=slides>
                    <li> <img src={{ asset( 'images/im__03.003a165e.png') }} alt="">
                        <div class=flex-caption>
                            <h3>Organiza tu lista de contactos</h3> Con tu conexión a redes sociales podrás identificar a tus amigos y tener toda su información actualizada. </div>
                    </li>
                    <li> <img src={{ asset( 'images/im__04.cd5b4db9.png') }} alt="">
                        <div class=flex-caption>
                            <h3>Convierte los números de teléfono de tus amigos</h3> Para que uses el beneficio de la tarifa RPM – RPM, ahorra saldo y continúa hablando. </div>
                    </li>
                    <li> <img src={{ asset( 'images/im__05.82ca081f.png') }} alt="">
                        <div class=flex-caption>
                            <h3>Acumula Puntaje</h3> Para que puedas canjearlo por premios, conviértete en cabeza de tu grupo y lidera la conexión. </div>
                    </li>
                </ul>
            </section>
        </section>
        <section id=downloadIcons>
            <section class=maximoAncho>
                <p>Disponible en:</p>
                <a href=""> <img src={{ asset( 'images/app_store.aded0c64.png') }} alt=""> </a>
                <a href=""> <img src={{ asset( 'images/Google-Play.5082aff3.png') }} alt=""> </a>
            </section>
        </section>
        <section id=joinUs class=maximoAncho>
            <h2>Únete a nuestra comunidad</h2> <img src={{ asset( 'images/man.4c8fa85a.png') }} alt="" class="col-lg-2 col-md-2 hidden-sm hidden-xs">
            <form action="" class="col-lg-8 col-md-6">
                <input type=text name=nombre placeholder="Tu Nombre">
                <input type=email name=email placeholder="Tu Email"> </form> <img src={{ asset( 'images/cloud.172000f1.png') }} alt="" class="col-lg-2 col-md-2 hidden-sm hidden-xs"> </section>
        <div class=clearfix></div>
        <footer>
            <section class=maximoAncho>
                <nav>
                    <ul>
                    	<li><img src="{{ asset( 'images/logo-copia.png') }}" alt=""></li>
                        <li class=hvr-underline-from-center><a href="">Inicio</a></li>
                        <li class=hvr-underline-from-center><a href="">Como Jugar</a></li>
                        <li class=hvr-underline-from-center><a href="">Sobre Nosotros</a></li>
                    </ul>
                </nav>
                <p id=copyright>ClubRPM | Todos los derechos reservados 2015</p>
                <div class=clearfix></div>
            </section>
        </footer>
        <script src={{ asset( 'scripts/vendor.5b02f5f6.js') }}></script>
        <script src={{ asset( 'scripts/main.f6978329.js') }}></script>
        <script src={{ asset( 'scripts/plugins.d41d8cd9.js') }}></script>
        <div style="display:none;">Created by Sólido | Ingenio Creativo</div>
