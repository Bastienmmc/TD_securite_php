<?php
spl_autoload_register(function ($class) {
    include 'class/' . $class . '.class.php';
});