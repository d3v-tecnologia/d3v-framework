<?php

namespace D3V\Util;

class Debug
{
    public static function dd($var, $html = true)
    {
        $output = print_r($var, true);
        if ($html) {
            echo "<pre>$output</pre>";
            return;
        }
        echo $output;
    }
}
