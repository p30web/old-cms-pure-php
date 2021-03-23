<?php

use Mixset\Captcha\Captcha;
use Mixset\Captcha\Exceptions\CaptchaException;

session_start();

// Set default charset and document type
header('Content-Type: text/html; charset=utf-8');

try {
    $config = require_once '../src/core/Helpers.php';
    $config = require_once '../src/exceptions/CaptchaException.php';
    $config = require_once '../src/Captcha.php';
    $config = require_once '../src/config/config.php';

    $captcha = new Captcha(
        $config['directory'],
        $config['font'],
        $config['image']
    );
    $captcha->generateCaptcha();
} catch (CaptchaException $e) {
    error_log($e->getMessage());
}
