<?php 

    class validador{ 
    

        public static function sanitizeName($nombre){
            return filter_var($nombre, FILTER_SANITIZE_STRING);
        }

        public static function validateUser($user){
            if(filter_var($user, FILTER_VALIDATE_EMAIL)){
                return false;
            }else{ 
                return true;
            }
        }

        public static function validateID($id){
            if(filter_var($id, FILTER_VALIDATE_INT)){
                return false;
            }else{
                return true;
            }
        }

        public static function sanitizeUser($user){
            return filter_var($user, FILTER_SANITIZE_EMAIL);
        }

        public static function encryptPass($pasword){
            return password_hash($pasword, PASSWORD_DEFAULT);
        }

        public static function validateDate($date){
            $pattern = '/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/';
            if(preg_match($pattern, $date) === 1){
                return false;
            }else{
                return true;
            }

        }

        public static function validateHour($hour){ 
            $pattern = '/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/';
            if(preg_match($pattern, $hour) === 1){
                return false;
            }else{
                return true;
            }
        }


        public static function validateHourSS($hour){ 
            $pattern = '/(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)/';
            if(preg_match($pattern, $hour) === 1){
                return false;
            }else{
                return true;
            }
        }

        public static function validateBool($bool){
            if(filter_var($bool, FILTER_VALIDATE_BOOLEAN)){
                return false;
            }else{
                return true;
            }
        }

        public static function userExist($conn, $user){
            $sql = "SELECT * FROM agenda.users WHERE user = '$user';";
            $result = $conn->ejecutarQuery($sql); 
            $rows = $result->num_rows; ;

            if($rows === 0){
                return false; 
            }else{
                return true;
            }
        }


    }

?>