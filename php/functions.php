<?php 
    function validate_string($str) {
        $str=filter_var($str,FILTER_SANITIZE_STRING);
        $str = trim($str);
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        return $str;
      }

?>
