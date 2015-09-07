<?php
/**
 * User: claudio
 * Date: 07-09-15
 * Time: 11:03 AM
 */

function loadJS($path)
{
    $finallyPath = $path;
    if (ENVIRONMENT == "production") {
        $pos = strpos($path, ".js");
        $finallyPath = substr($path, 0, $pos) . ".min.js";

        if (!file_exists(FCPATH . $finallyPath)) $finallyPath = $path;
    }

    $finallyPath = base_url($finallyPath);

    return "<script type='text/javascript' src='$finallyPath'></script>";
}

function loadCSS($path)
{
    $finallyPath = $path;
    if (ENVIRONMENT == "production") {
        $pos = strpos($path, ".css");
        $finallyPath = substr($path, 0, $pos) . ".min.css";

        if (!file_exists(FCPATH . $finallyPath)) $finallyPath = $path;
    }

    $finallyPath = base_url($finallyPath);

    return "<link rel='stylesheet' href='$finallyPath' type='text/css'/>";
}