<?php
    // error_reporting(-1);
    // ini_set('display_errors', 'On');

    // // build API request
    // $APIUrl = 'https://api.email-validator.net/api/verify';
    // $Params = array(
    //     'EmailAddress' => 'lioa.co@hn.vnn.vn',
    //     'APIKey' => 'ev-25439515cd97726dd4f624dc2dc4ad7e'
    // );
    // $Request = http_build_query($Params, '', '&');
    // $ctxData = array(
    // 'method'=>"POST",
    // 'header'=>"Connection: close\r\n".
    // "Content-Type: application/x-www-form-urlencoded\r\n".
    // "Content-Length: ".strlen($Request)."\r\n",
    // 'content'=>$Request);
    // $ctx = stream_context_create(array('http' => $ctxData));

    // // send API request
    // $result = json_decode(file_get_contents(
    // $APIUrl, false, $ctx));

    // // check API result
    // if ($result && $result->{'status'} > 0) {
    //     switch ($result->{'status'}) {
    //         // valid addresses have a {200, 207, 215} result code
    //         // result codes 114 and 118 need a retry
    //         case 200:
    //         case 207:
    //         case 215:
    //         echo "Address is valid.";
    //         break;
    //         case 114:
    //         // greylisting, wait 5min and retry
    //         break;
    //         case 118:
    //         // api rate limit, wait 5min and retry
    //         break;
    //         default:
    //         echo "Address is invalid.";
    //         echo $result->{'info'};
    //         echo $result->{'details'};
    //         break;
    //     }
    // } else {
    //     echo $result->{'info'};
    // }

?>

<?php
//set_time_limit(0);
?>
<!-- <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=Windows-1251">
        <title>Sample</title>
    </head>
    <body> -->
        <?php
        // include_once 'Controller/class.verifyEmail.php';

        // $email = 'nhalinh@lioa.com';

        // $vmail = new verifyEmail();
        // $vmail->setStreamTimeoutWait(20);
        // $vmail->Debugoutput= 'html';

        // $vmail->setEmailFrom('factlinkportvn@gmail.com');

        // if ($vmail->check($email)) {
        //     echo 'email &lt;' . $email . '&gt; exist!';
        // } elseif (verifyEmail::validate($email)) {
        //     echo 'email &lt;' . $email . '&gt; valid, but not exist!';
        // } else {
        //     echo 'email &lt;' . $email . '&gt; not valid and not exist!';
        // }
        ?>
    <!-- </body>
</html> -->
<?php
    echo date("Ymd");
    //$query1 = "SELECT * FROM `flc_member` ORDER BY rand("20190817") LIMIT 10;";
    $query2 = "SELECT * FROM `flc_member` ORDER BY rand(" . date("Ymd") . ") LIMIT 10;";
    var_dump($query2);
?>