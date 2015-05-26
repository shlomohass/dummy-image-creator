<?php

// Handle the parameters.
$strSize  = (isset($_GET['size']))?
                                    strtolower(preg_replace("/[^0-9xX]/","",$_GET['size']))
                                  :
                                    NULL;
$strType  = (isset($_GET['type']) && in_array(strtolower($_GET['type']), array('png','jpg','gif'), true ))?
                                    strtolower($_GET['type'])
                                  :
                                    'png';
$strBg    = (isset($_GET['bg']) && ctype_alnum($_GET['bg']) && strlen($_GET['bg']) < 7)?
                                    strtolower($_GET['bg'])
                                  :
                                    'C7C7C7';
$strColor = (isset($_GET['color']) && ctype_alnum($_GET['color']) && strlen($_GET['color']) < 7)?
                                    strtolower($_GET['color'])
                                  :
                                    '8F8F8F';

if ($strSize == NULL) {
    die('<b>You have to provide the size of the image.</b> Example: 250x320.</b>');
}

$strWidth = explode('x', $strSize);
$strHeight = (isset($strWidth[1]))?$strWidth[1]:$strWidth[0];
$strWidth = $strWidth[0];


if (ctype_digit($strWidth) && ctype_digit($strHeight)) {

    if (($strWidth > 9999) or ($strHeight > 9999)) {
            die('<b>The maximum picture size can be 9999x9999px.</b>');
    }
    
    $intFontSize = $strWidth / 16;
    if ($intFontSize < 9) $intFontSize = 9;
    $strFont = "./impact.ttf";
    $strText = $strWidth . ' X ' . $strHeight;

    $objImg = @imagecreatetruecolor($strWidth, $strHeight) or die('Sorry, there is a problem with the GD lib.');

    function html2rgb($strColor) {
            if (strlen($strColor) == 6) {
                    list($strRed, $strGreen, $strBlue) = array($strColor[0].$strColor[1], $strColor[2].$strColor[3], $strColor[4].$strColor[5]);
            } elseif (strlen($strColor) == 3) {
                    list($strRed, $strGreen, $strBlue) = array($strColor[0].$strColor[0], $strColor[1].$strColor[1], $strColor[2].$strColor[2]);
            }

            $strRed   = hexdec($strRed);
            $strGreen = hexdec($strGreen);
            $strBlue  = hexdec($strBlue);

            return array($strRed, $strGreen, $strBlue);
    }

    $strBgRgb    = html2rgb($strBg);
    $strColorRgb = html2rgb($strColor);
    $strBg       = imagecolorallocate($objImg, $strBgRgb[0], $strBgRgb[1], $strBgRgb[2]);
    $strColor    = imagecolorallocate($objImg, $strColorRgb[0], $strColorRgb[1], $strColorRgb[2]);

    imagefilledrectangle($objImg, 0, 0, $strWidth, $strHeight, $strBg);

    $arrTextBox    = imagettfbbox($intFontSize, 0, $strFont, $strText);
    $strTextWidth  = $arrTextBox[4] - $arrTextBox[1];
    $strTextHeight = abs($arrTextBox[7]) + abs($arrTextBox[1]);
    $strTextX      = ($strWidth - $strTextWidth) / 2;
    $strTextY      = ($strHeight - $strTextHeight) / 2 + $strTextHeight;
    imagettftext($objImg, $intFontSize, 0, $strTextX, $strTextY, $strColor, $strFont, $strText);

    switch ($strType) {
            case 'png':
                    header('Content-Type: image/png');
                    imagepng($objImg);
                    break;
            case 'gif':
                    header('Content-Type: image/gif');
                    imagegif($objImg);
                    break;
            case 'jpg':
                    header('Content-Type: image/jpeg');
                    imagejpeg($objImg);
                    break;
    }

    imagedestroy($objImg);
    
} else {
	die('<b>You have to provide the size of the image.</b> Example: 250x320.</b>');
}
