<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <!--<meta name="viewport" content="width=device-width, maximun-scale=1"/>-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
    <!--CSS-->
        <link href='<?php echo $_layoutParams['ruta_css'];?>bootstrap.min.css' rel='stylesheet' type='text/css'>
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
        <ul class="nav nav-pills">
            
 
              <?php if(isset($_layoutParams['menu_top'])): ?>
                 <?php for($i = 0; $i < count($_layoutParams['menu_top']); $i++): ?>
                    <?php if(Session::get('autenticado') && $i == 0): ?>
                        <li><img src="<?php echo BASE_URL;?>public/img/usuario/user.png" alt="imagen" style="width: 34px; height: 34px;" class="img-circle"></li>
                        <li><a href="<?php echo $_layoutParams['menu_top'][$i]['enlace']?>"><?php echo $_layoutParams['menu_top'][$i]['titulo']?></a></li>
                        <li><a href="#">Messages <span class="badge">0</span></a></li>
                    <?php else: ?>
                        <li><a href="<?php echo $_layoutParams['menu_top'][$i]['enlace']?>"><?php echo $_layoutParams['menu_top'][$i]['titulo']?></a></li>
                    <?php endif; ?>
                 <?php endfor; ?>
             <?php endif; ?>
                    
             
        </ul>
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
                
                <div class="row caja_search">
                    <div class="col-lg-4">
                        <div class="input-group">
                          <input type="text" class="form-control">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Buscar</button>
                          </span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
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
                                    <?php if(isset($_layoutParams['menu_left'])): ?>
                                        <?php for($i = 0; $i < count($_layoutParams['menu_left']); $i++): ?>
                                            <?php if(isset($_SESSION['vista_actual'])): ?>
                                                <?php if(Session::get('vista_actual') == $_layoutParams['menu_left'][$i]['id']): ?>
                                                    <li class="current"><a  href="<?php echo $_layoutParams['menu_left'][$i]['enlace']?>"><?php echo $_layoutParams['menu_left'][$i]['titulo']?></a></li>
                                                <?php else: ?>
                                                    <li><a href="<?php echo $_layoutParams['menu_left'][$i]['enlace']?>"><?php echo $_layoutParams['menu_left'][$i]['titulo']?></a></li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </ul>
                        </nav>
                        
                        <h6>REVISTAS</h6>
                        <nav class="menu_vertical">
                                <ul>
                                        <li><a href="<?php echo BASE_URL .'revistas/info/Ciencias'; ?>">Ciencias</a></li>
                                        <li><a href="">Opcion</a></li>
                                        <li><a href="">Divulgaciones Matem&aacute;ticas</a></li>
                                        <li><a href="">Enl@ce</a></li>
                                        <li><a href="">Anartia</a></li>
                                </ul>
                        </nav>
                </aside>

            <section id="contenido">
                <div id="pad_conten">
                    <noscript><p>Para el correcto funcionamiento de la p&acaute;gina de tener habilitado JavaScript..!</p></noscript>
                    <?php if(isset($this->_error)): ?>
                    <div id="error"><?php echo $this->_error; ?></div>
                    <?php endif; ?>

                    <?php if(isset($this->_mensaje)): ?>
                    <div id="mensaje"><?php echo $this->_mensaje; ?></div>
                    <?php endif; ?>
