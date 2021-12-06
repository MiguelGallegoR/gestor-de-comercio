<html>
    <head>
        <?php 
           
            
            require_once 'BaseDatos.php';
            
        ?>
        <meta charset="UTF-8"/>
        <title>Index.php</title>
        <link rel="stylesheet" type="text/css" href="/pac-entornos/estilos.css"/>
    </head>
    <body>
        
        <div class="contenedor-index">
            <form action="index.php" method="POST">
                
    
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" required/>
                
                <div class="clearfix"></div>
    
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required/>
                
                <div class="clearfix"></div>
                
                <input type="submit" value="Acceder"/>
                <?php
                        
                    if(!empty($_POST)){
                        getUser($_POST['usuario'],$_POST['email']);
                    }
                     
                ?>
            </form>
        
        </div>

   </body> 
  
</html>