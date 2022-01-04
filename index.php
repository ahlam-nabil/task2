<?php
    function nextchar($char){
        ++$char;
        if(strlen($char)>1){
            $char = $char[0];
        }
        echo $char;
    }
    nextchar('l');
    
?>