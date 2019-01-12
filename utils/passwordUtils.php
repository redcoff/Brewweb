<?php
// Osolení hesla a jeho verifikace
const SALT = '3q2kJh';

function passwordHash($password) {
    return password_hash($password.SALT, PASSWORD_DEFAULT);
}

function passwordVerify($a, $b) {
    return password_verify($a.SALT, $b);
}