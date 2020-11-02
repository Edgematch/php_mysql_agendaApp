<?php 
    class conectorDB{ 

        //atributos de la clase conector, con los que se inicializa la conexion con la base de datos
        private $host ='localhost:3306'; 
        private $user = 'newuser'; 
        private $password = '12345'; 
        private $conexion; 

        //metodo encargado de inicializar la conexion con la base datos
        function initConexion($database){
            $this->conexion = new mysqli($this->host, $this->user, $this->password, $database);
            if($this->conexion->connect_error){
                return "Error ".$this->conexion->connect_error;
            }else{
                return "OK";
            }
        }

        //metodo que se encarga de ejecutar las sentencias sql a la base de datos
        function ejecutarQuery($query){
            return $this->conexion->query($query);
        }

        //cierra la conexion con la base de datos 
        function cerrarConexion(){
            $this->conexion->close();
        }

        //metodo encargado de insertar informacion a la baase de datos
        function insertData($tabla, $data){
            $sql = "INSERT INTO ".$tabla.' (';
            foreach($data as $key => $value){
                if ($value !== end($data)){ 
                    $sql .= $key. ', ';
                }else{ 
                    $sql .= $key. ') ' ; 
                }
            }

            $sql .= "VALUES ("; 

            foreach($data as $key => $value){ 
                if($value !== end($data)){
                    $sql .= $value. ", ";
                }else{
                    $sql .= $value. ");";
                }
            }
            
           return $this->ejecutarQuery($sql);
            
        }
        
        function checkLogin($conn, $username, $password){
            $sql = "SELECT * FROM agenda.users WHERE user = '$username';";
            $result = $conn->ejecutarQuery($sql); 

            if($row = $result->fetch_assoc()){
                if($row['user'] = $username){
                    $hashedPass = $row['password'];
                    if(password_verify($password, $hashedPass)){
                        return true;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }


        }

        function getEvents($conn, $username){
            $sql = "SELECT * FROM agenda.events WHERE user_id = '$username';";
            return $conn->ejecutarQuery($sql); 
        }

        function deleteEvent($conn, $user, $id){
            $sql = "DELETE FROM agenda.events WHERE id = $id AND user_id = '$user';";
            return $conn->ejecutarQuery($sql);
        }

        function updateEvent($conn, $data, $user, $id ){
            $sql = "UPDATE agenda.events SET ";
            foreach($data as $key => $value){
                if ($value !== end($data)){ 
                    $sql .= $key.' = '.$value. ", ";
                }else{ 
                    $sql .= $key.' = '.$value. " " ; 
                }
            }
            $sql .= "WHERE user_id = $user AND id = $id;"; 

            return $conn->ejecutarQuery($sql);
            
        }


    }


?>