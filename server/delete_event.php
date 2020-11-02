<?php
    session_start();
    require 'lib.php';
    require 'validar_datos.php'; 

    if(isset($_SESSION['user'])){
        
        $raw_id = $_POST['id']; 

        if(validador::validateID($raw_id) !== false){
            $response['msg'] = "No se esta ingresando un id valido";
            echo json_encode($response);
            exit();
        }

        $conn = new conectorDB(); 

        if($conn->initConexion('agenda') === "OK"){

            $id = $raw_id; 

            if($conn->deleteEvent($conn, $_SESSION['user'], $id)){
                $response['msg'] =  "OK";
            }else{
                $response['msg'] =  "Error creando el evento";
            }
            
            $conn->cerrarConexion(); //cerra la conexion con la base de datos

        }else{
            $response['msg'] = "Error conectando a la base de datos";
            die($die);
        }
    }else{
        $response['msg'] = "El usuario no tiene session en el servidor";
    }

    echo json_encode($response);

 ?>
