<?php 
    use Cloudinary\Configuration\Configuration;
    require "../vendor/autoload.php";

    $config = Configuration::instance();
    $config->cloud->cloudName = 'nextgencoder';
    $config->cloud->apiKey = '418413822739342';
    $config->cloud->apiSecret = 'A4PW_2pBeqW-0sDA9zu2w1pKbuU';
    $config->url->secure = true;

?>