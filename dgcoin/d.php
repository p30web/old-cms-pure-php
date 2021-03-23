<?php

require_once 'block_io.php';


$apiKey = "ec0b-27ff-210d-48b4";
$version = 2; // API version
$pin = "1EvEHeF3yy17A0T";
$block_io = new BlockIo($apiKey, $pin, $version);

print_r($block_io->get_balance());

echo"<hr>";

print_r($block_io->get_current_price(array()));

