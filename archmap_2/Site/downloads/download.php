<?php
    header('Content-Type: application/download');
    header('Content-Disposition: attachment; filename="catalog.rtf"');
    header("Content-Length: " . filesize($_SERVER['DOCUMENT_ROOT'] . "/archmap_2/Site/downloads/CatalogLintelsDoc.rtf"));

    $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/archmap_2/Site/downloads/CatalogLintelsDoc.rtf", "r");
    fpassthru($fp);
    fclose($fp);
    
  
?>