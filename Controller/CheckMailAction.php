<?php

    require_once __DIR__.'/../PHPMailer/class.verifyEmail.php';

    $email = $_POST['emailToCheck'];

    $vmail = new verifyEmail();
    $vmail->setStreamTimeoutWait(20);
    $vmail->Debugoutput= 'html';

    $vmail->setEmailFrom('factlinkportvn@gmail.com');

    if ($vmail->check($email)) {
        echo '<p style="color:green">Email &lt;' . $email . '&gt; exist!</p>';
    } elseif (verifyEmail::validate($email)) {
        echo '<p style="color:red">Email &lt;' . $email . '&gt; valid, but not exist!</p>';
    } else {
        echo '<p style="color:red">Email &lt;' . $email . '&gt; not valid and not exist!</p>';
    }
?>