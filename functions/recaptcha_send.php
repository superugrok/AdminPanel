<?php
require_once('recaptchalib-v2.php');

$secret = "6Lcnc9wUAAAAAOvx_3ql7j8tM1eOoCrDcjsupCFm";
$resp = null;
$error = null;
$reCaptcha = new ReCaptcha($secret);
// Was there a reCAPTCHA response?
if ($_POST["g-recaptcha-response"]) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}

if($resp != null && $resp->success)
{
    echo true;
}
else
{
    echo false;
}
?>