<?php

function getRandomString(int $n): string {
    return bin2hex(random_bytes($n / 2));
}

function hashPassword(string $password, string $salt): string {
    return hash('sha256', $password . $salt);
}

function checkMagicNumbers(string $fileName): bool {
    $acceptedMagicNumbers = ["89504E47", "FFD8FFDB", "FFD8FFE0", "FFD8FFEE", "FFD8FFE1", "47494638"];
    $f = fopen($fileName, "r");
    $magicNumber = fread($f, 4);
    fclose($f);
    if (in_array(strtoupper(substr(bin2hex($magicNumber), 0, 8)), $acceptedMagicNumbers)) {
        return true;
    }
    return false;
}

function checkSuffix(string $fileName): bool {
    $acceptedSuffixes = ["png", "jpg", "gif"];
    $suffix = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (in_array($suffix, $acceptedSuffixes)) {
        return true;
    }
    return false;
}

function validateFile(array $file): bool {
    $maxFileSize = 5000000;
    $validMagicNumber = checkMagicNumbers($file["tmp_name"]);
    $validFileSize = ($file["size"] <= $maxFileSize);
    $validSuffix = checkSuffix($file["name"]);
    if ($validMagicNumber && $validFileSize && $validSuffix) {
        return true;
    }
    return false;
}

function ensureDirectoryExists(string $path): void {
    if (!is_dir($path)) {
        mkdir($path);
    }
}

?>