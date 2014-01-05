<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <!--<meta name="viewport" content="width=device-width, maximun-scale=1"/>-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
    <!--CSS-->
        <link href='<?php echo $_layoutParams['ruta_css'];?>bootstrap.min.css' rel='stylesheet' type='text/css'>
        <link href="<?php echo $_layoutParams['ruta_css'];?>bootstrap-responsive.min.css" rel='stylesheet' type='text/css'>
        <link href="<?php echo $_layoutParams['ruta_css'];?>estilo.css" rel="stylesheet"  type="text/css" />
        <!--JavaScript-->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>-->
        <script src="<?php echo BASE_URL;?>public/js/bootstrap.min.js"></script>
        <script src="<?php echo BASE_URL;?>public/js/jquery-2.0.3.min.js"></script>
        <script src="<?php echo BASE_URL;?>public/js/resize.js"></script>
        <script src="<?php echo BASE_URL;?>public/js/jquery.validate.js"></script>
        
        
        <?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
        <?php for($i=0; $i < count($_layoutParams['js']); $i++): ?>
        
        <script src="<?php echo $_layoutParams['js'][$i] ?>" type="text/javascript"></script>
        
        <?php endfor; ?>
        <?php endif; ?>

        <script>

            $(window).resize(function(){
                var elem = $(this);
            
                // Update the info div width and height - replace this with your own code
                // to do something useful!
                /*alert('window width: ' + elem.width() + ', height: ' + elem.height() );*/

                if(elem.width() > 768){
                    menu = $('#menu_horizontal').find('ul');
                    menu.removeClass('open-menu');
                }
            });

            $(function() {
             
                var btn_movil = $('#nav-mobile'),
                menu = $('#menu_horizontal').find('ul');
             
                // Al dar click agregar/quitar clases que permiten el despliegue del menú
                btn_movil.on('click', function (e) {
                    e.preventDefault();
             
                    var el = $(this);
             
                    el.toggleClass('nav-active');
                    menu.toggleClass('open-menu');
                });
            });

        </script>
</head>

<body>
    
<div id="bar-top">
    <div id="usuario">
        <?php if(isset($_layoutParams['menu_top'])): ?>
            <?php for($i = 0; $i < count($_layoutParams['menu_top']); $i++): ?>
            <?php if($i == 0): ?>
                <a href="<?php echo $_layoutParams['menu_top'][$i]['enlace']?> " class="perfil"><?php echo $_layoutParams['menu_top'][$i]['titulo']?></a>
            <?php else: ?>
                <a href="<?php echo $_layoutParams['menu_top'][$i]['enlace']?>"><?php echo $_layoutParams['menu_top'][$i]['titulo']?></a>
            <?php endif; ?>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
</div>

<div id="contenedor">
        <header class="grid-header">

                <div id="logoLuz" class="col-3-12">
                        <img src="<?php echo $_layoutParams['ruta_img'];?>logoLuz.png" alt="LUZ"><p><span>UNIVERSIDAD</span></br><span id="delZulia">DEL ZULIA</span></p>
                </div>

                <div id="logo" class="col-5-12">
                    <p><a href="">Revistas</a><a href="">Arbitradas</a></p>
                </div>

                <div id='search-box' class="col-4-12">
				  <form action='/search' id='search-form' method='get' target='_top'>
				    <input id='search-text' name='q' placeholder='Escriba aqu&iacute;' type='text'/>
				    <button id='search-button' type='submit'><span>Buscar</span></button>
				  </form>
				</div>

        </header>

        <nav id="menu_horizontal">
            <a class="nav-mobile" id="nav-mobile" href="#"></a>
            <ul>
                <?php if(isset($_layoutParams['menu_horizontal'])): ?>
                <?php for($i = 0; $i < count($_layoutParams['menu_horizontal']); $i++): ?>
                <li><a href="<?php echo $_layoutParams['menu_horizontal'][$i]['enlace']?>"><?php echo $_layoutParams['menu_horizontal'][$i]['titulo']?></a></li>
                <?php endfor; ?>
                <?php endif; ?>
            </ul>
        </nav>
    
        <section id="caja_contenido">

                <aside id="panel_left">
                        <h6>REVISTAS ARBITRADAS</h6>
                        <nav class="menu_vertical">
                                <ul>
                                        <li class="current"><a href="">Inicio</a></li>
                                        <li><a href="">otra cosa</a></li>
                                </ul>
                        </nav>
                </aside>

            <section id="contenido">
                <noscript><p>Para el correcto funcionamiento de la p&acaute;gina de tener habilitado JavaScript..!</p></noscript>
                <?php if(isset($this->_error)): ?>
                <div id="error"><?php echo $this->_error; ?></div>
                <?php endif; ?>

                <?php if(isset($this->_mensaje)): ?>
                <div id="mensaje"><?php echo $this->_mensaje; ?></div>
                <?php endif; ?>