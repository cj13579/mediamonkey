<?php
$download = $_POST['download'];

//echo $download;

if (isset($download))
{
	if (file_exists($download)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($download));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($download));
    ob_clean();
    flush();
    readfile($download);
    exit;
    }
}

?>