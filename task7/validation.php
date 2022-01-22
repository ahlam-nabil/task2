<?php
    class validation{
        function clean($input){
            return trim(strip_tags(stripslashes($input)));
        }

        public function validates($input,$flag){
            $status = true;

            switch($flag){
                case 1:
                    if(empty($input)){
                        $staus = false;
                    }

                case 2:
                    if(strlen($input)<=50){
                        $status = false;
                    }    

                case 3:
                    if(!preg_match("/^[a-zA-Z-' ]*$/",$input)){
                        $status = false;
                    }

                case 4:
                    $allowedext = ['png','jpg'];
                    if(!in_array($input,$allowedext)){
                        $status = false;
                    }
            }
            return $status;
        }
    }
?>