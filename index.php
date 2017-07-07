<?php
//
// index.php
// jsonpdf
//
// Created by William Shakour on August 16, 2016.
// Copyright © 2016 WillShex Limited. All rights reserved.
//
require_once 'vendor/autoload.php';

use mikehaertl\wkhtmlto\Pdf;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('FPDF_FONTPATH', 'font/');

$document = request('document');
$settings = json_decode(request('settings', '{}'), true);
$name = request('name', 'doc.pdf');

if (isset($document)) {
    $pdf = new Pdf($settings);
    $pdf->addPage($document);
    
    if (! $pdf->send($name)) {
        throw new Exception('Could not create PDF: ' . $pdf->getError());
    }
}

function request($name, $default = null)
{
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
}