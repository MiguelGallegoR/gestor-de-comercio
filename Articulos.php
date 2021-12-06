<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Artículos</title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <link href="/pac-entornos/estilos.css" rel="stylesheet"/>
        <?php
            //Iniciamos sesión y hacemos un include el archivo BaseDatos.php
            session_start();
            include "BaseDatos.php";
            //Si existe el campo página del array $_GET la variable 
            //pagina tendrá este valor, si no será igual a 0 
            if(isset($_GET['pagina'])){
                $pagina = $_GET['pagina'];
            }else{
                $pagina = 0;
            }
        ?>
    </head>
    <body>

        <h1>Artículos</h1>
        <?php
        //Si la $_Session tiene el valor "autorizado" o "superadmin", mostrará 
        //el botón crear un nuevo producto
        if($_SESSION['usuario'] == "autorizado" || ($_SESSION['usuario'] == "superadmin")){
            echo'<a class= "boton" href="formArticulos.php?formulario=vacio">'
            . 'Crear un nuevo producto</a>';
        }
        
        ?>

    <!-- Creamos la tabla -->
        <table>
            <style>
                table,td,th{border: 1px solid;}
            </style>
            <tr>
            <th scope="col">
                <a href="Articulos.php?campos=productid" class="boton">ID
                </a>
            </th>
            <th scope="col">
                <a href="Articulos.php?campos=categoria" class="boton" > Categoría
                </a>
            </th>
            <th scope="col">
                <a href="Articulos.php?campos=name" class="boton"> Nombre
                </a>
            </th>
            <th scope="col">
                <a href="Articulos.php?campos=cost" class="boton"> Coste
                </a>
            </th>
            <th scope="col">
                <a href="Articulos.php?campos=price" class="boton"> Precio
                </a>
            </th>


            <?php
            //Si la $_Session['usuario'] es igual a "superadmin" la tabla 
            //mostrará la columna Manejo
            if($_SESSION['usuario'] == "superadmin")
            echo '<th scope="col">Manejo</th>';  
            ?>
        
            </tr>
    
  
    <?php
       //Si existe el campo página del array $_GET la 
       // $_SESSION['campos'] será igual a $_GET['campos']
       if(isset($_GET['campos']))
            $_SESSION['campos'] = $_GET['campos'];
       //Llamamos a la función muestraProductos
        muestraProductos();
        
        
    ?>
  
        </table>
        <div>
        <a class= "boton" href= "Articulos.php<?php 
            //Si la variable pagina menos 10 es mayor que 0, imprimirá un 
            //botón para ir a la pagina anterior
            if (isset($pagina))
                if($pagina - 10 > 0)
                    echo '?pagina=' . ($pagina-10); ?>"> <<< </a>
        
        
        <a class = "boton" href="Articulos.php?pagina=<?php
            //Si la variable pagina no existe, imprimirá 10
            //Si la variable pagina mas 10 es menos que la funcion numRegistros
            //imprime pagina mas 10, si no imprime 50
            if (!isset($pagina))
                echo 10;
            else if($pagina + 10 < numRegistros())
                echo $pagina + 10;
            else echo 50;?>">>>></a> 
             <a class="boton" href="Acceso.php">Volver</a>     

        </div>

    </body>
</html>
