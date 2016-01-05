<?php

/**
 * @author Vladimir
 * @since 14-09-15
 */
function spanishDateToISO($sDate) {
    if($sDate=='' || $sDate==null || $sDate =='0000-00-00 00:00:00')
        return null;
    $formatos = array(
        array("d#m#Y H#i#s", "Y-m-d H:i"),
        array("d#m#Y H#i", "Y-m-d H:i"),
        array("d#m#Y", "Y-m-d")
    );

    foreach ($formatos as $f) {
        if ($myDateTime = DateTime::createFromFormat($f[0], $sDate))
            return $myDateTime->format($f[1]);
    }
    return null;
}

function ISODateTospanish($sDate, $time = true) {
    if($sDate=='' || $sDate==null || $sDate =='0000-00-00 00:00:00')
        return null;
    if ($time) {
        $formatos = array(
            array("Y#m#d H#i#s", "d-m-Y H:i"),
            array("Y#m#d H#i", "d-m-Y H:i"),
            array("Y#m#d", "d-m-Y")
        );
    } else {
        $formatos = array(
            array("Y#m#d H#i#s", "d-m-Y"),
            array("Y#m#d H#i", "d-m-Y"),
            array("Y#m#d", "d-m-Y")
        );
    }

    foreach ($formatos as $f) {
        if ($myDateTime = DateTime::createFromFormat($f[0], $sDate))
            return $myDateTime->format($f[1]);
    }
    return null;
}

function ISOTimeTospanish($sDate) {
    if($sDate=='' || $sDate==null || $sDate =='0000-00-00 00:00:00')
        return null;
    $formatos = array(
        array("Y#m#d H#i#s", "H:i"),
        array("Y#m#d H#i", "H:i"),
    );

    foreach ($formatos as $f) {
        if ($myDateTime = DateTime::createFromFormat($f[0], $sDate))
            return $myDateTime->format($f[1]);
    }
    return null;
}
