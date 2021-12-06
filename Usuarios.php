
<!DOCTYPE html>

<html lang="es">
    <head>
        <title>Usuarios</title>
        <meta charset="UTF-8">
        <link href="/pac-entornos/estilos.css" rel="stylesheet"/>
        <?php
            //Iniciamos sesión y hacemos un include el archivo BaseDatos.php
            session_start();
            include "BaseDatos.php";
            
            
        ?>
    </head>
    <body>
    
    <h1>Usuarios</h1>

    <table>
        <style>
           table,td,th{border: 1px solid;}
        </style>
    <tr>
        <th scope="col">
            <a href="Usuarios.php?campos=userid" class="boton">ID
            </a>
        </th>
        <th scope="col">
            <a href="Usuarios.php?campos=fullname" class="boton" > Nombre
            </a>
            </th>
        <th scope="col">
            <a href="Usuarios.php?campos=email" class="boton"> Email
            </a>
        </th>
        <th scope="col">
            <a href="Usuarios.php?campos=lastaccess" class="boton"> Ultimo Acceso
            </a>
        </th>
        <th scope="col">
            <a href="Usuarios.php?campos=enabled" class="boton"> Enabled
            </a>
        </th>
        <th scope="col">
          Manejo
        </th>
        
    </tr>
    
  
    <?php
       //Si la sesion es igual a autorizado o superadmin imprime el boton 
       //para crear un nuevo usuario
        if($_SESSION['usuario'] == "autorizado" || ($_SESSION['usuario'] == "superadmin")){
            echo'<a class= "boton" href="formUsuarios.php?formulario=vacio">Crear un nuevo usuario</a>';
        }

       //Llama a la funcion muestraUsuarios de BaseDatos.php 
         muestraUsuarios();
        
    ?>
  
    </table>
     <a class="boton" href="Acceso.php">Volver</a>

    </div>

    </body>
</html>


   


