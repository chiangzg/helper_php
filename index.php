<?php
/**
 * Created by PhpStorm.
 * User: leaffall
 * Date: 2018/4/20
 * Time: 上午12:07
 */
require './vendor/autoload.php';
$res = \Helper\Curl::downloadFile('http://www.leaffall.xyz/csv/online.csv');

print_r($res);