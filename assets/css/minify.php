<?php

require_once 'cssmin.php';
$input = '../../assets/css/base.css';
$result = CssMin::minify(file_get_contents($input));
echo $result;