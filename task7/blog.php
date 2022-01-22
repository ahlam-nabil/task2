<?php
    session_start();
    require('dbconnect.php');
    require('validation.php');

    class blog{
        private $title;
        private $content;
       

        public function blogtest($val1,$val2){
            $validate = new validation();

            $this->title = $validate->clean($val1);
            $this->content = $validate->clean($val2);

            $errors= [];

            if(!$validate->validates($this->title,1)){
                $errors['title'] = 'field required';
            }else if(!$validate->validates($this->title,3)){
                $errors['title'] = 'invalid string';
            }

            if(!$validate->validates($this->content,1)){
                $errors['content'] = 'field required';
            }else if(!$validate->validates($this->content,2)){
                $errors['content'] = 'length must be > 50';
            }

        //     if(!$validate->validates($_FILES['$this->image']['name'],1)){
        //         $errors['image'] = ['filed required'];
        //     }else{
        //         $imgtemppath = $_FILES['$this->image']['tmp_name'];
        //         $imgname = $_FILES['image']['name'];

        //         $extarray = explode('.',$imgname);
        //         $imageexten = strtolower(end($extarray));

        //         if(!$validate->validates($imageexten,4)){
        //             $errors['image'] = 'inavlid extension';
        //         }else{
        //             $finalname = time().rand().'.'.$imageexten;
        //     }
        // }

        if(count($errors)>0){
            $message = $errors;
        }else{
            // $dispath = './uploads/'.$finalname;
            // if(move_uploaded_file($imgtemppath,$dispath)){
                $db =new db();
                $sql = "insert into blog (title,content) values ('$this->title' , '$this->content')";
                $op = $db->query($sql);

                if($op){
                    $message = 'The post has been published';
                }else{
                    $message= 'error please try again';
                }
            //}
        }
        $_SESSION['message'] = $message;
        // var_dump($_SESSION['message']);
        // exit();
    }
   
}
?>