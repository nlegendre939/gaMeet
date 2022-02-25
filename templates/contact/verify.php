<?php
    if(!empty($_POST['firstname'])&& !empty($_POST['email'])){
        $secret ="6LcqTnoeAAAAAGVDNtLz_dsz2b9sxw9Sg3JCIk6o";
        $response = htmlspecialchars($_POST['g-recaptcha-response']);
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $request = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";


        $get = file_get_contents($request);
        $decode = json_decode($get, true);

        if ($decode['sucess'])
            echo"Ok";
        else
            echo "Error";    
        
    }