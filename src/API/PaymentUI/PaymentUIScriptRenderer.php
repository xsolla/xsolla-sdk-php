<?php

namespace Xsolla\SDK\API\PaymentUI;

class PaymentUIScriptRenderer 
{
    public static function send($token, $isSandbox = false)
    {
        echo self::render($token, $isSandbox);
    }

    public static function render($token, $isSandbox = false)
    {
        $template =
<<<EOF
<script>
     var options = {
         access_token: '%s',
         sandbox: %s
     };
     var s = document.createElement('script');
     s.type = "text/javascript";
     s.async = true;
     s.src = "https://xsolla.cachefly.net/embed/paystation/1.0.1/widget.min.js";
     s.addEventListener('load', function (e) {
         XPayStationWidget.init(options);
     }, false);
     var head = document.getElementsByTagName('head')[0];
     head.appendChild(s);
 </script>
EOF;
        return sprintf($template, $token, $isSandbox ? 'true' : 'false');
    }
}