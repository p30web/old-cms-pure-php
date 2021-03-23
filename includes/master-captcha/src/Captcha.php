<?php
/**
 * @author Dominik Ryńko <http://rynko.pl/>
 * @author Simon Jarvis
 * @Link: http://www.white-hat-web-design.co.uk/articles/php-captcha.ph
 * @Link: http://rynko.pl/captcha-class-php-czy-jestes-czlowiekiem
*/

namespace Mixset\Captcha;

use Mixset\Captcha\Core\Helpers;
use Mixset\Captcha\Exceptions\CaptchaException;

/**
 * Class Captcha
 * @package Captcha\Core
*/
class Captcha
{
    /**
     * Supported extension of font file
    */
    const FONT_EXTENSION = 'ttf';

    /**
     * Configuration data for captcha image
     *
     * @var
    */
    private $config = [];

    /**
     * Captcha constructor.
     *
     * @param $directory
     * @param $font
     * @param array $captcha
     *
     * @throws CaptchaException
    */
    public function __construct($directory, $font, array $captcha)
    {
        if (empty($font) === true) {
            throw new CaptchaException('Font name cannot be empty');
        }

        $explodeFontName = explode('.', $font);
        $ext = end($explodeFontName);

        if ($ext !== self::FONT_EXTENSION) {
            throw new CaptchaException(
                'Font\'s extension must be ' . self::FONT_EXTENSION
            );
        }

        $this->config['font'] = rtrim($directory, '/') . '/' . $font;
        $this->config['width'] = $captcha['width'];
        $this->config['height'] = $captcha['height'];
        $this->config['characters'] = $captcha['characters'];
    }

    /**
     * Display captcha image
     *
     * Save code to the session
     *
     * @return void
    */
    public function generateCaptcha()
    {
        $code = Helpers::generateCode($this->config['characters']);
        $width = $this->config['width'];
        $height = $this->config['height'];

        // Font size will be 75% of the image height
        $fontSize = $height * 0.45;
        $image    = imagecreate($width, $height);

        // Set the colours
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        $textColor       = imagecolorallocate($image, 46, 118, 126);
        $noiseColor      = imagecolorallocate($image, 118, 173, 201);

        // Generate random dots in background
        for ($i = 0; $i < ($width * $height) / 10; $i ++) {
            imagefilledellipse(
                $image,
                mt_rand(0, $width),
                mt_rand(0, $height),
                1,
                1,
                $noiseColor
            );
        }

        // Generate random lines in background
        for ($i = 0; $i < ($width * $height) / 310; $i ++) {
            imageline(
                $image,
                mt_rand(0, $width),
                mt_rand(0, $height),
                mt_rand(0, $width),
                mt_rand(0, $height),
                $noiseColor
            );
        }

        // Create textbox and add text
        $textbox = imagettfbbox($fontSize, 0, $this->config['font'], $code);
        $x       = ($width - $textbox[4]) / 2;
        $y       = ($height - $textbox[5]) / 2;
        imagettftext(
            $image,
            $fontSize,
            0,
            $x,
            $y,
            $textColor,
            $this->config['font'],
            $code
        );

        // Output captcha image to browser
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
        $_SESSION['security_code'] = $code;
    }
}
