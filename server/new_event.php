<?php
  
  session_start();
  require 'lib.php';
  require 'validar_datos.php'; 

  if(isset($_SESSION['user'])){

    if($_POST['allDay'] === "true"){
        $raw_allDay = 1;
        $raw_titulo = $_POST['titulo'];
        $raw_start_date = $_POST['start_date'];

        if(validador::validateDate($raw_start_date)!== false){
            $response['msg'] = "Las fechas ingresadas no son validas";
            echo json_encode($response);
            exit();
        }
        
    }else{
        $raw_allDay = 0;
        $raw_titulo = $_POST['titulo']; 
        $raw_start_date = $_POST['start_date'];
        $raw_end_date = $_POST['end_date'];
        $raw_end_hour = $_POST['end_hour'];
        $raw_start_hour = $_POST['start_hour'];

        if(validador::validateDate($raw_start_date)!== false || validador::validateDate($raw_end_date)!==false){
            $response['msg'] = "Las fechas ingresadas no son validas";
            echo json_encode($response);
            exit();
        }

        if(validador::validateHour($raw_start_hour)!== false || validador::validateHour($raw_end_hour) !== false){
            $response['msg'] = 'Las horas ingresadas no son validas';
            echo json_encode($response);
            exit();
        }
    }

    

    $conn = new conectorDB(); 

    if($conn->initConexion("agenda") === "OK"){

        if($raw_allDay === 1){
            $datos['user_id'] = "'".$_SESSION['user']."'";
            $datos['titulo'] = "'".validador::sanitizeName($raw_titulo)."'";
            $datos['fecha_inicio'] = "'".$raw_start_date."'";
            $datos['dia_completo'] = $raw_allDay;
        }else{
            $datos['user_id'] = "'".$_SESSION['user']."'";
            $datos['titulo'] = "'".validador::sanitizeName($raw_titulo)."'";
            $datos['fecha_inicio'] = "'".$raw_start_date."'";
            $datos['fecha_fin'] = "'".$raw_end_date."'";
            $datos['hora_inicio'] = "'".$raw_start_hour."'";
            $datos['hora_fin'] = "'".$raw_end_hour."'";
            $datos['dia_completo'] = $raw_allDay;
        }

        

        if($conn->insertData("events", $datos)){
            $response['msg'] =  "OK";
        }else{
            $response['msg'] =  "Error creando el evento";
        }
        
        $conn->cerrarConexion(); //cerra la conexion con la base de datos

    }else{
        $response['msg'] = "Error conectando a la base de datos";
        die($conn);
    }





  }else{
    $response['msg'] = "El usuario no tiene session en el servidor";
  }

  echo json_encode($response);


 ?>
