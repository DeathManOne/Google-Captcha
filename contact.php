<?php

$reCaptcha  =  new \Google\Captcha('CLIENT_SECRET');
$response   =  $reCaptcha->check($_POST['g-recaptcha-response']);



if ( $response->getSuccess() ):
    // GOOD
else:
    // NOT GOOD
endif;
