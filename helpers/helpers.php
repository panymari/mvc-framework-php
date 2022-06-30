<?php

function redirect($code, $url)
{
    switch ($code) {
        case 301:
            {
                header("Location: $url", true, $code);
            }

        break;
    }
}
