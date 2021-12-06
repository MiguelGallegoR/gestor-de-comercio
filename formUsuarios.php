<html>
    <head>
        <?php 
           
            
            require_once 'BaseDatos.php';
            
        ?>
        <meta charset="UTF-8"/>
        <title>formUsuarios.php</title>
        <link rel="stylesheet" type="text/css" href="/pac-entornos/estilos.css"/>
    </head>
    <body>
        
        <div class="contenedor-formUsuarios">
            
            <?php        
               //Si existe $_GET['formulario']
            if(isset($_GET['formulario'])){
                //Si $_GET['formulario'] es igual a 'editar':
                 //Imprime el mensaje de modificar, la variable formulario
                 // obtiene el valor 'editar' y la variable campos es igual a
                 // $_GET['id'] llamando a la funcion informacionUsuario
                    if($_GET['formulario']=='editar'){
                        echo "<p> Se va a <b>modificar</b> un usuario</p>";
                        $formulario = 'editar';
                        $campos = informacionUsuario($_GET['id']);
                    
                 //Si $_GET['formulario'] es igual a 'eliminar'  
                 //Imprime el mensaje de eliminar, la variable formulario
                 // obtiene el valor 'eliminar' y la variable campos es igual a
                 // $_GET['id'] llamando a la funcion informacion Usuario 
                    }elseif($_GET['formulario']=='eliminar'){
                        echo "<p> Se va a <b>eliminar</b> un usuario</p>";
                        $formulario = 'eliminar';
                        $campos = informacionUsuario($_GET['id']);
                 
                //Si no la variable formulario es igual a "vacio" y se imprime 
                //el mensaje de añadir un usuario nuevo         
                    } else{
                        $formulario = 'vacio';
                        echo "<p> Se va a <b>añadir</b> un usuario nuevo</p>";
                    }
            }else{
                
            //Si no la variable formulario no vale nada    
                $formulario = '';
            
            }
                
                   
        //Si no existe el campo boton del array $_POST: crea el formulario    
            if(!isset($_POST['boton'])){     
            ?>
            
            <form action="formUsuarios.php" method="POST">
                <label for="id">ID:</label>
                <input type="number" name="UserID" required value="<?php
                //Operador ternario. Si la variable formulario vale "vacio"
                //imprime "", si no imprime el campo 'UserID' del array campos
                echo ($formulario == "vacio" ? "" : ($campos["UserID"]));?>"/>
                
                <div class="clearfix"></div>
    
                <label for="nombre">Nombre:</label>
                <input type="text" name="FullName" required value="<?php
                //Operador ternario. Si la variable formulario vale "vacio"
                //imprime "", si no imprime el campo 'FullName' del array campos
                echo ($formulario == "vacio" ? "" : ($campos["FullName"]));?>" />
               
                <div class="clearfix"></div>
                
                <label for="contraseña">Contraseña:</label>
                <input type="text" name="Password" required value="<?php
                //Operador ternario. Si la variable formulario vale "vacio"
                //imprime "", si no imprime el campo 'Password' del array campos
                echo ($formulario == "vacio" ? "" : ($campos["Password"]));?>"/>
                
                <div class="clearfix"></div>
                
                <label for="email">Correo:</label>
                <input type="email" name="Email" required value="<?php
                //Operador ternario. Si la variable formulario vale "vacio"
                //imprime "", si no imprime el campo 'Email' del array campos
                echo ($formulario == "vacio" ? "" : ($campos["Email"]));?>" />
                
                <div class="clearfix"></div>
                
                <label for="LastAccess">Ultimo Acceso:</label>
                <input type="date" name="LastAccess" required value="<?php
                //Operador ternario. Si la variable formulario vale "vacio"
                //imprime "", si no imprime el campo 'LastAccess' del array campos
                echo ($formulario == "vacio" ? "" : ($campos["LastAccess"]));?>" />
                
                <div class="clearfix"></div>
                
                <label for="enabled">Autorizado:</label>
                
                <input type="radio" name="Enabled" value="1" <?php
               //Operador ternario. Si la variable formulario vale "vacio"
               //imprime "", si no imprime el campo 'Enabled' del array campos
               //Que es igual al seleccionado Si
                echo ($formulario == "vacio" ? "" :
                        ($campos["Enabled"] == "1" 
                        ? "selected='selected'" : "")); ?>">Si</option>
                <input type="radio" name="Enabled" value="0" <?php
                //Operador ternario. Si la variable formulario vale "vacio"
               //imprime "", si no imprime el campo 'Enabled' del array campos
               //Que es igual al seleccionado No
                echo ($formulario == "vacio" ? ""
                        : ($campos["Enabled"] == "0" 
                        ? "selected='selected'" : "")); ?>">No</option>
                
                <div class="clearfix"></div>
                <?php 
                //En el caso de que formulario valga vacio, imprime un boton 
                 //con valor añadir. Si vale editar, imprime un boton con valor 
                 //editar. Si vale eliminar, imprime un boton con valor eliminar
                    switch ($formulario){
                        case "vacio":
                             echo '<input type="submit" name="boton" value="Añadir">';
                             break;
                        case "editar":
                             echo '<input type="submit" name="boton" value="Editar">';
                             break;
                        case "eliminar":
                             echo '<input type="submit" name="boton" value="Borrar">';
                             break;
                    default:
                    echo "";
                    }
        
               }
               //Si $_POSt no esta vacío y $_POST['boton'] vale añadir:
                   if(!empty($_POST)&& $_POST['boton'] == "Añadir"){
                       //Llama a la funcion addUser pasandole los valores del $_POST 
                       addUser($_POST['UserID'],$_POST['FullName'],
                               $_POST['Password'],$_POST['Email'],
                               $_POST['LastAccess'], $_POST['Enabled']);
                //Si $_POSt no esta vacío y $_POST['boton'] vale editar:
                //Llama a la funcion modificarUsuario pasandole los valores del $_POST   
                    }elseif(!empty($_POST) && $_POST['boton'] == "Editar"){
                       modificarUsuario($_POST['UserID'],$_POST['FullName'],
                               $_POST['Password'],$_POST['Email'],
                               $_POST['LastAccess'], $_POST['Enabled']);
                   
                //Si $_POSt no esta vacío y $_POST['boton'] vale borrar:
                //Llama a la funcion borrarUsuario pasandole los valores del $_POST       
                    }elseif(!empty($_POST) && $_POST['boton'] == "Borrar"){
                       borrarUsuario($_POST['UserID']);
                   }
                
                 
                
                ?>
            </form>
        <a href='Usuarios.php'>Volver</a>
        </div>

    
   </body> 
  
</html>
