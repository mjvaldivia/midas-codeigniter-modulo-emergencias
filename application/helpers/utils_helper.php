<?php

function spanishDateToISO($sDate)
{
    $formatos = array(
        array("d#m#Y H#i#s", "Y-m-d H:i:s"),
        array("d#m#Y H#i", "Y-m-d H:i"),
        array("d#m#Y", "Y-m-d")
    );

    foreach($formatos as $f) {
        if ($myDateTime = DateTime::createFromFormat($f[0], $sDate)) return $myDateTime->format($f[1]);
    }
    return null;
}
function ISODateTospanish($sDate)
{
    $formatos = array(
        array("Y#m#d H#i#s", "d-m-Y H:i:s"),
        array("Y#m#d H#i", "d-m-Y H:i"),
        array("Y#m#d", "d-m-Y")
    );

    foreach($formatos as $f) {
        if ($myDateTime = DateTime::createFromFormat($f[0], $sDate)) return $myDateTime->format($f[1]);
    }
    return null;
}

