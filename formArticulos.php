<html>
    <head>
        <?php 
           
            
            require_once 'BaseDatos.php';
            
        ?>
        <meta charset="UTF-8"/>
        <title>formArticulos.php</title>
        <link rel="stylesheet" type="text/css" href="/pac-entornos/estilos.css"/>
    </head>
    <body>
        
        <div class="contenedor-formArticulos">
            
            <?php        
             //Si existe $_GET['formulario']
            if(isset($_GET['formulario'])){
                 //Si $_GET['formulario'] es igual a 'editar':
                 //Imprime el mensaje de modificar, la variable formulario
                 // obtiene el valor 'editar' y la variable campos es igual a
                 // $_GET['id'] llamando a la funcion informacion Articulo
                    if($_GET['formulario']=='editar'){
                        echo "<p> Se va a <b>modificar</b> un artículo</p>";
                        $formulario = 'editar';
                        $campos = informacionArticulo($_GET['id']);
                    
                 //Si $_GET['formulario'] es igual a 'eliminar'  
                 //Imprime el mensaje de eliminar, la variable formulario
                 // obtiene el valor 'eliminar' y la variable campos es igual a
                 // $_GET['id'] llamando a la funcion informacion Articulo       
                    }elseif($_GET['formulario']=='eliminar'){
                        echo "<p> Se va a <b>eliminar</b> un artículo</p>";
                        $formulario = 'eliminar';
                        $campos = informacionArticulo($_GET['id']);
                    
                  //Si no la variable formulario es igual a "vacio" y se imprime 
                  //el mensaje de añadir un articulo nuevo   
                    } else{
                        $formulario = 'vacio';
                        echo "<p> Se va a <b>añadir</b> un artículo nuevo</p>";
                    }
            }else{
                //Si no la variable formulario no vale nada
                $formulario = '';
            }
                
               
            //Si no existe el campo boton del array $_POST: crea el formulario
               if(!isset($_POST['boton'])){     
            ?>
            
            <form action="formArticulos.php" method="POST">
                <label for="id">ID:</label>
                <input type="number" name="ProductID" required value="<?php
                //Operador ternario. Si la variable formulario vale "vacio"
                //imprime "", si no imprime el campo 'ProductID' del array campos
                echo ($formulario == "vacio" ? "" : ($campos["ProductID"]));
                ?>"/>
                
                <div class="clearfix"></div>
    
                <label for="nombre">Nombre:</label>
                <input type="text" name="Name" required value="<?php
                //Operador ternario. Si la variable formulario vale "vacio"
                //imprime "", si no imprime el campo 'name' del array campos
                echo ($formulario == "vacio" ? "" : ($campos["name"]));
                ?>" />
               
                <div class="clearfix"></div>
                
                <label for="coste">Coste:</label>
                <input type="number" name="Cost" required value="<?php
                //Operador ternario. Si la variable formulario vale "vacio"
                //imprime "", si no imprime el campo 'Cost' del array campos
                echo ($formulario == "vacio" ? "" : ($campos["Cost"]));
                ?>"/>
                
                <div class="clearfix"></div>
                
                <label for="precio">Precio:</label>
                <input type="number" name="Price" required value="<?php
                //Operador ternario. Si la variable formulario vale "vacio"
                //imprime "", si no imprime el campo 'Price' del array campos
                echo ($formulario == "vacio" ? "" : ($campos["Price"]));
                ?>" />
                
                <div class="clearfix"></div>
                
                <label for="categoria">Categoria:</label>
               
                <select name="categoria" id="categoria" >
                  
                <option name="categoria" value="1" <?php
               //Operador ternario. Si la variable formulario vale "vacio"
               //imprime "", si no imprime el campo 'Categoria' del array campos
               //Que es igual al seleccionado Pantalon
                echo ($formulario == "vacio" ? "" 
                        : ($campos["Categoria"] == "PANTALÓN" 
                        ? "selected='selected'" : "")); ?>">PANTALÓN</option>
                <option name="categoria" value="2" <?php
               //Operador ternario. Si la variable formulario vale "vacio"
               //imprime "", si no imprime el campo 'Categoria' del array campos
               //Que es igual al seleccionado Camisa
                echo ($formulario == "vacio" ? "" 
                        : ($campos["Categoria"] == "CAMISA" 
                        ? "selected='selected'" : "")); ?>">CAMISA</option>
                <option name="categoria" value="3" <?php 
               //Operador ternario. Si la variable formulario vale "vacio"
               //imprime "", si no imprime el campo 'Categoria' del array campos
               //Que es igual al seleccionado Jersey
                echo ($formulario == "vacio" ? "" 
                        : ($campos["Categoria"] == "JERSEY" 
                        ? "selected='selected'" : "")); ?>">JERSEY</option>
                <option name="categoria" value="4" <?php
               //Operador ternario. Si la variable formulario vale "vacio"
               //imprime "", si no imprime el campo 'Categoria' del array campos
               //Que es igual al seleccionado Chaqueta
                echo ($formulario == "vacio" ? "" 
                        : ($campos["Categoria"] == "CHAQUETA" 
                        ? "selected='selected'" : "")); ?>">CHAQUETA</option>
                      
                </select>
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
                //Llama a la funcion addItem pasandole los valores del $_POST       
                  addItem($_POST['ProductID'],$_POST['Name'],$_POST['Cost'],
                          $_POST['Price'], $_POST['categoria']);
                //Si $_POSt no esta vacío y $_POST['boton'] vale editar:
                //Llama a la funcion modificarArticulo pasandole los valores del $_POST     
                }elseif(!empty($_POST) && $_POST['boton'] == "Editar"){
                  modificarArticulo($_POST['ProductID'],$_POST['Name'],
                          $_POST['Cost'],$_POST['Price'], $_POST['categoria']);
                //Si $_POSt no esta vacío y $_POST['boton'] vale borrar:
                //Llama a la funcion borrarArticulo pasandole los valores del $_POST
                }elseif(!empty($_POST) && $_POST['boton'] == "Borrar"){
                   borrarArticulo($_POST['ProductID']);
                }
                
                 
                
                ?>
            </form>
        <a href='Articulos.php'>Volver</a>
        </div>

    
   </body> 
  
</html>