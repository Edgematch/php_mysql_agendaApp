<?php
  session_start();
  require 'lib.php';

  if (isset($_SESSION['user'])) {

    $conn = new conectorDB(); 

    if($conn->initConexion('agenda') === "OK"){
        
        $result = $conn->getEvents($conn, $_SESSION['user']);

        $i = 0;

        while($rows = $result->fetch_assoc()){
  
          if($rows['dia_completo'] === '1'){
            $response['eventos'][$i]["id"] = $rows['id'];
            $response['eventos'][$i]["allDay"] = true;
            $response['eventos'][$i]["start"] = $rows['fecha_inicio'];
            $response['eventos'][$i]["end"] = $rows['fecha_fin'];
            $response['eventos'][$i]["title"] = $rows['titulo'];
          }else{
            $response['eventos'][$i]["id"] = $rows['id'];
            $response['eventos'][$i]["allDay"] = false;
            $response['eventos'][$i]["start"] = $rows['fecha_inicio']." ".$rows['hora_inicio'];
            $response['eventos'][$i]["end"] = $rows['fecha_fin']." ".$rows['hora_fin'];
            $response['eventos'][$i]["title"] = $rows['titulo'];
          }   

          $i++;
        }
      

        $conn->cerrarConexion();

        $response['msg'] = "OK";

    }else{
        $response['msg'] = "Error conectando a la base de datos";
        die($die);
    }
    

  }else {
    $response['msg'] = "El usuario no tiene session en el servidor";
  }

  echo json_encode($response);



 ?>
