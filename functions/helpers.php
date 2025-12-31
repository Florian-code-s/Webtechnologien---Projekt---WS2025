<?php

function getRandomString($n) {
    return bin2hex(random_bytes($n / 2));
}

function hashPassword($safePassword, $salt) {
    return hash('sha256', $safePassword . $salt);
}

function checkMagicNumbers($fileName)
{
    $acceptedMagicNumbers = ["89504E47", "FFD8FFDB", "FFD8FFE0", "FFD8FFEE", "FFD8FFE1", "47494638"];
    $f = fopen($fileName, "r");
    $magicNumber = fread($f, 4);
    fclose($f);
    if (in_array(strtoupper(substr(bin2hex($magicNumber), 0, 8)), $acceptedMagicNumbers)) {
        return true;
    }
    return false;
}

function getFileSuffix($fileName)
{
    $pos = strrpos($fileName, ".");
    $suffix = substr($fileName, $pos + 1);
    return $suffix;
}

function checkSuffix($fileName)
{
    $acceptedSuffixes = ["png", "jpg", "gif"];
    $suffix = getFileSuffix($fileName);
    if (in_array($suffix, $acceptedSuffixes)) {
        return true;
    }
    return false;
}

function validateFile($file)
{
    $maxFileSize = 5000000;
    $validMagicNumber = checkMagicNumbers($file["tmp_name"]);
    $validFileSize = ($file["size"] <= $maxFileSize);
    $validSuffix = checkSuffix($file["name"]);
    if ($validMagicNumber && $validFileSize && $validSuffix) {
        return true;
    }
    return false;
}

function ensureDirectoryExists($path)
{
    if (!is_dir($path)) {
        mkdir($path);
    }
}

?>