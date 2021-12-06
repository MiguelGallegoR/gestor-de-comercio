
<html>
    <head>
         <?php 
            require_once 'BaseDatos.php';
        ?>
         <meta charset="UTF-8"/>
         <title>Acceso.php</title>
        <link rel="stylesheet" type="text/css" href="/pac-entornos/estilos.css"/>
    </head>
    <body>
              
        <div class="contenedor-acceso">
    
            <a class="a-acceso" href="Articulos.php"> 
                <button id="boton-articulos">Articulos</button>
            </a>
                <?php
                        session_start();
                     
                    if(($_SESSION['usuario'])== "superadmin"){
                        
                        echo '<a class="a-acceso"href="Usuarios.php"> '
                        . '<button id="boton-usuarios">Usuarios</button>';
                    }
                     
                ?>
               
            <a class="a-acceso"href="index.php">
                <button id="boton-volver">Volver</button>
            </a>
 
        </div>
    </body>
</html>
