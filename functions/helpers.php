<?php
function getRandomString($n) {
    return bin2hex(random_bytes($n / 2));
}

function hashPassword($safePassword, $salt) {
    return hash('sha256', $safePassword . $salt);
}
?>