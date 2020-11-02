<?php
 session_start();
 require 'lib.php';
 require 'validar_datos.php'; 

 if(isset($_SESSION['user'])){
     
    $raw_id = $_POST['id'];  
    $raw_start_date = $_POST['start_date'];
    $raw_end_date = $_POST['end_date'];
    $raw_end_hour = $_POST['end_hour'];
    $raw_start_hour = $_POST['start_hour'];


     $conn = new conectorDB(); 

     if($conn->initConexion('agenda') === "OK"){

        $id = $raw_id;
        $user = "'".$_SESSION['user']."'";

        $datos['fecha_inicio'] = "'".$raw_start_date."'";
        $datos['fecha_fin'] = "'".$raw_end_date."'";
        $datos['hora_inicio'] = "'".$raw_start_hour."'";
        $datos['hora_fin'] = "'".$raw_end_hour."'";


         if($conn->updateEvent($conn, $datos, $user, $id)){
             $response['msg'] =  "OK";
         }else{
             $response['msg'] =  "Error actualizando el evento";
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
