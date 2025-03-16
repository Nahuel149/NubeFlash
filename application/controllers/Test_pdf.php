<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_pdf extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load HTML2PDF library
        $this->load->library('Html2pdf');
    }

    public function index() {
        echo "Welcome to PDF Test Page";
        echo "<br><a href='" . base_url('test_pdf/generate') . "'>Generate Sample PDF</a>";
        echo "<br><a href='" . base_url('test_pdf/download') . "'>Download Sample PDF</a>";
    }

    public function generate() {
        // Basic HTML content for testing
        $html = '
        <h1>PDF Generation Test</h1>
        <p>This is a test PDF document generated using dompdf.</p>
        <hr>
        <h2>Features to Test:</h2>
        <ul>
            <li>Basic text formatting</li>
            <li>UTF-8 characters: áéíóú ñ</li>
            <li>Table support</li>
        </ul>
        <table border="1" style="width: 100%;">
            <tr>
                <th>Header 1</th>
                <th>Header 2</th>
            </tr>
            <tr>
                <td>Content 1</td>
                <td>Content 2</td>
            </tr>
        </table>
        ';

        // Configure PDF options
        $this->html2pdf->folder('./assets/pdfs/');    // folder to save PDF files
        $this->html2pdf->filename('test_document.pdf');  // name for the PDF
        $this->html2pdf->paper('a4', 'portrait');     // paper size and orientation
        
        // Set the HTML content
        $this->html2pdf->html($html);
        
        // Display PDF in browser
        if($this->html2pdf->create('save')) {
            echo "PDF generated successfully. <a href='" . base_url('assets/pdfs/test_document.pdf') . "'>View PDF</a>";
        } else {
            echo "Error generating PDF.";
        }
    }

    public function download() {
        // Basic HTML content for testing
        $html = '
        <h1>PDF Download Test</h1>
        <p>This is a test PDF document for download testing.</p>
        <hr>
        <h2>Download Features:</h2>
        <ul>
            <li>Direct download</li>
            <li>File attachment headers</li>
            <li>Content-type verification</li>
        </ul>
        ';

        // Configure PDF options
        $this->html2pdf->folder('./assets/pdfs/');    // folder to save PDF files
        $this->html2pdf->filename('download_test.pdf');  // name for the PDF
        $this->html2pdf->paper('a4', 'portrait');     // paper size and orientation
        
        // Set the HTML content
        $this->html2pdf->html($html);
        
        // Force download the PDF
        if($this->html2pdf->create('download')) {
            // PDF will be downloaded automatically
            return;
        } else {
            echo "Error generating PDF for download.";
        }
    }
} 