<?php
//Función para crear la conexión con la base de datos.
function crearConexion(){
    $db = mysqli_connect("localhost", "root" , "" , "pac3_daw", 3308);
    $acentos = $db->query("SET NAMES 'utf8'");
    return $db;
}
//Función para comprobar si el usuario existe en la bbdd y que tipo de usuario es.
function getUser($nombre,$email){
 //Realizamos la conexión a la bbdd llamando a la función crearConexion 
 //y la guardamos en una variable.
 $conexion = crearConexion();
 //Realizamos la consulta que nos mostrara todas las filas de la tabla user
 //donde el campo Email y FullName coincidan con los parametros $email y $nombre
 //que le pasamos a la función
 $sql1 ="SELECT * FROM user WHERE Email = '$email' AND  FullName = '$nombre'";
 $login = mysqli_query($conexion, $sql1);
 $result = mysqli_fetch_assoc($login);
 //Guardamos el resultado de la consulta  $login en un array asociativo.Si existe
 //ese resultado:
 if(isset($result)){
     //Iniciamos una sesión. Guardamos el resultado del campo 'UserId' en una
     //variable $id, que tendra el valor $_Session['usuario'].
     session_start();
     $id = $result['UserID'];
     $_SESSION['usuario'] = $id;
     //Realizamos un echo con el mensaje de bienvenida y el enlace a Acceso.php
     echo "<p>Bienvenido $nombre, pulsa <a href='Acceso.php'>AQUÍ</a> para continuar.</p>";
     //Creamos la variable fecha con el formato 'Y-m-d'. Realizamos la consulta 
     //para que cada vez que un usuario entre se actualice su LastAcces.
     $fecha = date('Y-m-d');
     $sql2 = "UPDATE user SET LastAccess='$fecha' WHERE UserID = '$id'";
     $updatequery = mysqli_query($conexion, $sql2);
     
    //Si el resultado  del campo Enabled es igual a 1, la $_Session['usuario']
    //tendrá el valor "autorizado". Si no tendra el valor "registrado".
    if($result['Enabled']==1){
        $_SESSION['usuario'] = "autorizado";
    } else {
        $_SESSION['usuario'] = "registrado";
    }
    //Realizamos otra consulta donde nos muestre el campo SuperAdmin de la tabla 
    //setup, que es igual a la variable $id declarada antes y guardamos
    //el resultado en una array asociativo.
    $sql3 = "SELECT SuperAdmin FROM setup WHERE SuperAdmin = '$id' ";
    $superadmin = mysqli_query($conexion, $sql3);
    $result = mysqli_fetch_assoc($superadmin);
    //Si existe que $id es igual a la consulta realizada, la $_Session['usuario]
    // tendrá el valor "superadmin".
    if(isset($result)){
        $_SESSION['usuario'] = "superadmin";
    }
 //Si no existe el resultado de la primera consulta no podra entrar y mostrará
 //este mensaje   
 } else {
     echo 'El usuario es incorrecto';
 }
 
}
//Esta función nos muestra la tabla con todos los articulos
function muestraProductos(){
//Realizamos la conexión a la bbdd y creamos la variable resultados por pagina
    $conexion = crearConexion();
    $resultados_por_pagina=10;
//Si existe el campo página del array $_GET la variable 
//pagina tendrá este valor, si no será igual a 0 
    if(isset($_GET['pagina'])){
        $pagina = $_GET['pagina'];
    }else{
        $pagina = 0;
    }
    
//Si existe el campo campos del array $_Session la variable 
//campo tendrá este valor y realizará la consulta ordenada por esta variable
    if(isset($_SESSION['campos'])){
        $campo = $_SESSION['campos'];
//Muestra el ProductID, category.name como Categoria, Cost, Price de la tabla 
//product INNER JOIN con la tabla category donde categoryID de la tabla product
//es igual a la categoryID de la tabla category, ordenda por campo y con limite
//pagina y resultados por pagina        
        $consulta = "SELECT ProductID, category.name AS Categoria, product.name, Cost, Price 
            FROM product INNER JOIN category ON product.categoryID = category.categoryID 
            ORDER BY $campo LIMIT $pagina, $resultados_por_pagina";
        
//Si no, muestra el ProductID, category.name como Categoria, Cost, Price de la tabla 
//product INNER JOIN con la tabla category donde categoryID de la tabla product
//es igual a la categoryID de la tabla category, con limite
//pagina y resultados por pagina          
    }else{
        
        $consulta = "SELECT ProductID, category.name AS Categoria, product.name, Cost, Price 
            FROM product INNER JOIN category ON product.categoryID = category.categoryID 
            LIMIT $pagina, $resultados_por_pagina";
        
    }
//Guarda el resultado de la consulta    
    $resultado = mysqli_query($conexion, $consulta);

//Mientras que la variable row sea igual al array asociativo del resultado 
//de la consulta: guarda el campo ProductID de este array  
//Si la $_Session['usuario'] es igual a "superadmin" imprime cada campo del array
//y llama a la funcion botonesArticulos con el valor filaid    
    while($row = mysqli_fetch_assoc($resultado)){
        $filaid = $row['ProductID'];
        if($_SESSION['usuario'] == "superadmin"){
            echo "<tr>";
            echo "<td>" . $row['ProductID']. "</td>\n";
            echo "<td>" . $row['Categoria'] . "</td>\n";
            echo "<td>" . $row['name'] . "</td>\n";
            echo "<td>" . $row['Cost']. "</td>\n";
            echo "<td>" . $row['Price']. "</td>\n";
            botonesArticulos($filaid);
            echo "</tr>\n";
//Si no imprime cada campo del array sin la funcion botonesArticulos        
        }else{
            echo "<tr>";
            echo "<td>" . $row['ProductID']. "</td>\n";
            echo "<td>" . $row['Categoria'] . "</td>\n";
            echo "<td>" . $row['name'] . "</td>\n";
            echo "<td>" . $row['Cost']. "</td>\n";
            echo "<td>" . $row['Price']. "</td>\n";
            echo "</tr>\n";
            
        }   
    }        
}
//Esta funcion muestra los botones para editar y eliminar productos 
function botonesArticulos($filaid){
    echo "<td>
            <a href=formArticulos.php?formulario=editar&id=$filaid>Editar</a>
            <a href=formArticulos.php?formulario=eliminar&id=$filaid>Eliminar</a>
            </td></tr>";
}
//Esta funcion muestra el numero de registros por pagina
function numRegistros(){
    $conexion = crearConexion();
    $consulta = "SELECT * FROM product";
    $resultado = mysqli_query($conexion, $consulta);
    
    return mysqli_num_rows($resultado);
}
//Esta función nos permite crear un nuevo producto
function addItem($ProductID, $Name, $Cost, $Price, $CategoryID){
//Realizamos la conexión a la bbdd y realizamos la consulta, en este caso un 
//INSERT INTO con los valores que le pasamos por parametro a la función.
    $conexion = crearConexion();
    $consulta = "INSERT INTO product(ProductID, Name, Cost, Price, CategoryID)"
            . " VALUES('$ProductID', '$Name', '$Cost', '$Price', '$CategoryID')";
    $resultado = mysqli_query($conexion, $consulta);
//Si existe la consulta nos imprime este mensaje    
    if(isset($consulta)){
        
        echo 'Se ha creado el producto correctamente';
//Si no existe la consulta nos imprime este mensaje        
    }else{
        echo 'Ha habido un problema, intentalo de nuevo';
    }   
}
//Esta función nos muestra los valores ya guardados en el formulario listos 
//para modificar. Crea una conexión con la bbdd, realiza la consulta que nos 
//muestra la información de cada producto donde el ProductID coincida con la 
//variable filaid que le pasamos por parametro. El resultado lo guarda en un 
//array que devuelve la función
function informacionArticulo($filaid){
    $conexion = crearConexion();
    $consulta = "SELECT ProductID, category.name AS
        Categoria, product.name, Cost, Price 
        FROM product INNER JOIN category 
        ON product.categoryID = category.categoryID WHERE ProductId = $filaid";
    $resultado = mysqli_query($conexion, $consulta);
    
    return mysqli_fetch_array($resultado);
}
//Esta función modifica los valores que hay en la tabla de productos por los 
//que queramos. Para ello crea una conexion a la bbdd  y realiza una consulta 
//UPDATE de la tabla product por los valores que le pasamos por parametro a 
//la función. Si se realiza la modificación imprime el mensaje correcto, si 
//no imprime el mensaje error al modifcar.
function modificarArticulo($id, $nombre, $coste, $precio, $categoria){
    $conexion = crearConexion();

    $consulta = "UPDATE product SET Name='$nombre', Cost='$coste', "
            . "Price='$precio', CategoryID='$categoria' WHERE ProductID = $id";

    $resultado = mysqli_query($conexion, $consulta);

    if($resultado){
        echo "correcto";
    }
    else{
        echo "Error al modificar el producto:";
    }
     mysqli_close($conexion);
}
//Esta función elimina el producto que deseemos pasandole un id por parametro 
//y realizando la conexión con la bbdd y una consulta DELETE. Si se elimina el 
//producto imprime el mensaje correcto, si no imprime el mensaje error al 
//borrar el producto
function borrarArticulo($id){
    
     $conexion = crearConexion();

    $consulta = "DELETE FROM product WHERE ProductID = $id";

    $resultado = mysqli_query($conexion, $consulta);

    if($resultado){
        echo "correcto";
    }
    else{
        echo "Error al borrar el producto:";
    }
     mysqli_close($conexion);
    
    
}
//Esta funcion muestra el listado de los usuarios
function muestraUsuarios(){
    //Si no existe el campo del array $_GET['campo'] la variable $campo 
    //vale'UserID'. Si no $campo vale $_GET['campos]
    if(!isset($_GET['campos'])){
        $campo = 'UserID';
    }else{    
        $campo = $_GET['campos'];
    }
    //Crea la conexion a la bbdd y muestra el UserID, Email, LastAcces y 
    //Enabled de la tabla user ordenados por $campo.
    $conexion = crearConexion();
    $consulta = "SELECT UserID, FullName, Email,LastAccess,Enabled FROM user ORDER BY $campo";
    $resultado = mysqli_query($conexion, $consulta);
    //Guarda el resultado en una matriz asociativa. Mientras que cada fila sea 
    //una matriz asociativa imprime cada campo. El campo LastAccess lo modifico 
    //al formato d-m-y.
    while($row = mysqli_fetch_assoc($resultado)){
       $row['LastAccess'] = date('d-m-y', strtotime($row["LastAccess"]));
       $filaid = $row['UserID'];
       //Si el id coincide con el del superadmin imprime la fila en rojo.
       if(consultarSuperAdmin($filaid)){
            echo "<tr>";
            echo "<td><font color='red'>" . $row['UserID']. "</font></td>\n";
            echo "<td><font color='red'>" . $row['FullName'] . "</font></td>\n";
            echo "<td><font color='red'>" . $row['Email'] . "</font></td>\n";
            echo "<td><font color='red'>" . $row['LastAccess'] . "</font></td>\n";
            echo "<td><font color='red'>" . $row['Enabled']."</font></td>\n";
            echo "</tr>\n";
        
        
        //Si no imprime la fila normal y los botones de editar y eliminar
        }else{
        echo "<tr>";
        echo "<td>" . $row['UserID']. "</td>\n";
        echo "<td>" . $row['FullName'] . "</td>\n";
        echo "<td>" . $row['Email'] . "</td>\n";
        echo "<td>" . $row['LastAccess'] . "</td>\n";
        echo "<td>" . $row['Enabled']."</td>\n";
        botonesUsuario($filaid);
        echo "</tr>\n";
         
        }   
        
    }
    
}
//Esta funcion consulta el id el superadmin. Si este coincide con el id que 
//le pasamos por parametro a la funcion devuelve true, si no false.
function consultarSuperAdmin($id){
    $conexion = crearConexion();
    $consulta = "SELECT SuperAdmin FROM setup";
    $resultadoSuperAdmin = mysqli_query($conexion, $consulta);
    $idSuperAdmin = mysqli_fetch_array($resultadoSuperAdmin);

    if($idSuperAdmin['SuperAdmin'] == $id){
        return true;
        
    }else{
        return false;
    }
    
}
//Esta funcion imprime los botones para añadir o eliminar un usuario
function botonesUsuario($filaid){
    echo "<td>
            <a href=formUsuarios.php?formulario=editar&id=$filaid>Editar</a>
            <a href=formUsuarios.php?formulario=eliminar&id=$filaid>Eliminar</a>
            </td></tr>";
}

//Esta funcion permite crear un nuevo usuario. Crea la conexion a la bbdd 
//y realiza una consulta INSERT a nuestra tabla con los valores pasados por 
//parametro a la funcion. Si se realiza la insrción imprime un mensaje, si no 
//imprime un mensaje de error
function addUser($UserID, $FullName, $Password, $Email, $LastAccess, $Enabled){
    
    $conexion = crearConexion();
    $consulta = "INSERT INTO user(UserID, FullName, Password, Email, LastAccess, Enabled)"
            . " VALUES('$UserID', '$FullName','$Password', '$Email', '$LastAccess', '$Enabled')";
    $resultado = mysqli_query($conexion, $consulta);
    
    if(isset($consulta)){
        
        echo 'Se ha creado el usuario correctamente';
        
    }else{
        echo 'Ha habido un problema, intentalo de nuevo';
    }
    
    
}
//Esta función nos muestra los valores ya guardados en el formulario listos 
//para modificar. Crea una conexión con la bbdd, realiza la consulta que nos 
//muestra la información de cada usuario donde el UserID coincida con la 
//variable filaid que le pasamos por parametro. El resultado lo guarda en un 
//array que devuelve la función
function informacionUsuario($filaid){
    $conexion = crearConexion();
    $consulta = "SELECT UserID, FullName, Password,Email, LastAccess, Enabled 
            FROM user WHERE UserID = $filaid";
    $resultado = mysqli_query($conexion, $consulta);
    
    return mysqli_fetch_array($resultado);
}
//Esta función modifica los valores que hay en la tabla de usuarios por los 
//que queramos. Para ello crea una conexion a la bbdd  y realiza una consulta 
//UPDATE de la tabla user por los valores que le pasamos por parametro a 
//la función. Si se realiza la modificación imprime el mensaje correcto, si 
//no imprime el mensaje error al modifcar.
function modificarUsuario($UserID, $FullName, $Password ,$Email, $LastAccess, $Enabled){

    $conexion = crearConexion();

    $consulta = "UPDATE user SET FullName='$FullName',"
            . " Password='$Password', Email='$Email',"
            . " LastAccess='$LastAccess', Enabled='$Enabled' WHERE UserID = $UserID";
 
    $resultado = mysqli_query($conexion, $consulta);

    if($resultado){
        echo "correcto";
    }
    else{
        echo "Error al modificar el usuario:";
    }
     mysqli_close($conexion);
}
//Esta función elimina el producto que deseemos pasandole un id por parametro 
//y realizando la conexión con la bbdd y una consulta DELETE. Si se elimina el 
//usuario imprime el mensaje correcto, si no imprime el mensaje error al 
//borrar el usuario
function borrarUsuario($id){
    
     $conexion = crearConexion();

    $consulta = "DELETE FROM user WHERE UserID = $id";

    $resultado = mysqli_query($conexion, $consulta);

    if($resultado){
        echo "correcto";
    }
    else{
        echo "Error al borrar el usuario:";
    }
     mysqli_close($conexion);
    
    
}