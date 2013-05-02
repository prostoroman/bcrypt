<?php

use KevinGH\Bcrypt\Bcrypt;

/**
 * Encodes a raw string using Blowfish.
 *
 * @see KevinGH\Bcrypt\Bcrypt
 *
 * @param string  $raw    The raw string.
 * @param string  $salt   The salt.
 * @param integer $cost   The cost.
 * @param boolean $broken Force broken implementation?
 *
 * @return string The encoded string.
 */
function bcrypt($raw, $salt = null, $cost = null, $broken = false)
{
    $bcrypt = Bcrypt::create($broken);

    if (null !== $cost) {
        $bcrypt->setCost($cost);
    }

    if (null === $salt) {
        $bcrypt->setSalt($bcrypt->generateSalt());
    } elseif (0 === strpos($salt, '$')) {
        $bcrypt->setEncoded($salt);
    } else {
        $bcrypt->setSalt($salt);
    }

    return $bcrypt($raw);
}

/**
 * Verifies a raw string against an encoded string.
 *
 * @param string $raw     The raw string.
 * @param string $encoded The encoded string.
 *
 * @return boolean TRUE if verified, FALSES if not.
 */
function bcrypt_verify($raw, $encoded)
{
    return ($encoded === bcrypt($raw, $encoded));
}
