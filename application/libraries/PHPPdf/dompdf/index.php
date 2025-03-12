<?php
require_once ('autoload.inc.php');
use Dompdf\Dompdf;
$html = '<div style="width: 100%; height: 420px; background-color: #b1b1b1; display: block;">
        <div style="width: 50%; height: 420px; border-right: solid 1px #333 !important; float: left;">asdfg</div>
        <div style="width: 50%; height: 420px; border-left: solid 1px #333 !important; float: left;">12345</div>
        <div style="width: 40px; height: 40px; background: #689F38; position: absolute; bottom: 41.871921182266384%; left: 28.691955526487906%; border: solid 1px #000; border-radius: 20px"><div align="center" style="color: #000; font-size: 10px; position: absolute; bottom: 0; left: 0">GR</div></div>
    </div>';
 
$pdf = new DOMPDF();
$pdf->set_paper('A4', 'portrait');
$pdf->load_html(utf8_decode($html));
$pdf->render();
// $pdf->stream('FicheroEjemplo.pdf');
$pdf->stream('dompdf_out.pdf', array('Attachment' => false));
exit(0);