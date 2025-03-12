<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Test_qr extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo "Welcome to QR Code Test Page";
    }

    public function generate() {
        $qrCode = new QrCode('Test QR Code');
        $qrCode->setSize(300);
        $writer = new PngWriter();
        
        header('Content-Type: image/png');
        echo $writer->writeString($qrCode);
    }

    public function download() {
        $qrCode = new QrCode('Test QR Code');
        $qrCode->setSize(300);
        $writer = new PngWriter();
        
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="qr-code.png"');
        echo $writer->writeString($qrCode);
    }
} 