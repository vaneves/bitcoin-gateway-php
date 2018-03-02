<?php 

function get($name, $default = null) {
    $value = old($name);
    if (isset($_GET[$name])) {
        $value = $_GET[$name];
    }
    return $value;
}