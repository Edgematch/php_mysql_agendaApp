<?php
    
    require 'lib.php'; //llamado de controladores con la base de datos
    require 'validar_datos.php';

    //variables para crear un nuevo usuario enviando el metodo POST desde Postman
    $raw_user = $_POST['user'];
    $raw_name = $_POST['name'];
    $raw_password = $_POST['password'];
    $raw_fecha = $_POST['fecha_nacimiento'];

    $conn = new conectorDB();//inicializador de la conexion con la base de datos

    //validacion de datos
    if(validador::validateUser($raw_user) !== false){
        echo "No esta ingresando un correo valido"; 
        exit();
    }

    if(validador::validateDate($raw_fecha) !== false){
        echo "No es una fecha valida"; 
        exit();
    }

    if($conn->initConexion('agenda') === 'OK'){

        if(validador::userExist($conn, $raw_user) !== false){
            echo "El usuario ya existe"; 
            $conn->cerrarConexion(); 
            exit();
        }


        $datos['user'] = "'".validador::sanitizeUser($raw_user)."'";
        $datos['name'] = "'".validador::sanitizeName($raw_name)."'"; 
        $datos['password'] = "'".validador::encryptPass($raw_password)."'"; 
        $datos['fecha_nacimiento'] = "'".$raw_fecha."'";

        if($conn->insertData("users", $datos)){
            echo "Se creo el usuario exitosamente";
        }else{
            echo "hubo un error creando el usuario";
        }
        
        $conn->cerrarConexion(); //cerra la conexion con la base de datos


    }else{
        echo 'Error conectando a la base de datos';
        die($conn);
    }
    

 ?>
