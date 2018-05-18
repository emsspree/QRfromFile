<?php

//---------------------------------------------------------------
// QRfromFile
//
// Copyright (c) 2018 Andre Trecksel
//
// URL: https://andre.trecksel.de/
//
// using
//
// QRCode for PHP5
//
// Copyright (c) 2009 Kazuhiko Arase
//
// URL: http://www.d-project.com/
//
// Licensed under the MIT license:
//   https://opensource.org/licenses/mit-license.php
//
// The word "QR Code" is registered trademark of
// DENSO WAVE INCORPORATED
//   http://www.qrcode.com/
//
//---------------------------------------------------------------------



    // URL or local path to file to read its contents
$source = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/vcard';
    // Debug:  header("Content-type: text/plain"); print($source); exit();

    // QR code element size in pixels
$elSize = 3;


# # # # # # # #


    // load classes
require_once("qrcode.php");
    // »QRCode for PHP5« by Kazuhiko Arase, https://github.com/kazuhikoarase/qrcode-generator/blob/master/php/qrcode.php


    // get contents of a file
function contents($pathtofile) {
    $cntnt = @file_get_contents($pathtofile);
    if ($cntnt === FALSE) {
        throw new Exception("'$pathtofile' konnte nicht gelesen werden.");
    } else {
        return $cntnt;
    }
}


    // let’s try
try {

        // get contents
    $contents = contents($source);
        // Debug:  header("Content-type: text/plain"); print($contents); exit();

    $qr = QRCode::getMinimumQRCode($contents, QR_ERROR_CORRECT_LEVEL_L);

        // header
    header("Content-type: image/png");    // image/gif

        // image creation (argument: size, margin)
    $im = $qr->createImage(1 * $elSize, 2 * $elSize);

        // output image data
    imagepng($im);    // imagegif($im);

        // free any memory associated with image
    imagedestroy($im);

} catch (Exception $e) {
        // output error
    header("Content-type: text/html");
    echo "<title>", "Fehler", "</title>", "<p>Fehler: ", $e->getMessage(), "</p>";
}
