<?php
    require 'lib.php';
    require 'validar_datos.php'; 

    $raw_username = $_POST['username']; 
    $password = $_POST['password'];

    if(validador::validateUser($raw_username)!==false || $raw_username=== ""){ 
        $response['msg'] = "Usuario no valido"; 
    }else{
        $conn = new conectorDB(); 
        $username = validador::sanitizeUser($raw_username);
        if ($conn->initConexion("agenda") === "OK"){
            if($conn->checkLogin($conn, $username, $password)){
                session_start(); 
                $_SESSION['user'] = $username;
                $response['msg'] = "OK";
                $conn->cerrarConexion();
            }else{
                $response['msg'] = "El usuario o la contraseña no coinciden";
            }
        }else{
          $response['msg'] = "error conectando a la base de datos";
        }

    }

    echo json_encode($response);



 ?>
