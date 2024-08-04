<?php
declare(strict_types=1);

namespace Src\Service\Auth;

use Exception;

class PasswordService
{
    public static function hashPassword(string $password): string
    {
        $salt = bin2hex(random_bytes(16));
        $hash = self::scrypt($password, $salt, 64);
        return $hash . '.' . $salt;
    }

    public static function comparePassword(string $storedPassword, string $suppliedPassword): bool
    {
        list($hashedPassword, $salt) = explode('.', $storedPassword);
        $suppliedHash = self::scrypt($suppliedPassword, $salt, 64);
        return hash_equals($hashedPassword, $suppliedHash);
    }

    private static function scrypt(string $password, string $salt, int $length): string
    {
        $saltBin = hex2bin($salt);
        if ($saltBin === false) {
            throw new Exception('Invalid salt value.');
        }

        $hash = sodium_crypto_pwhash(
            $length,
            $password,
            $saltBin,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_ALG_DEFAULT
        );

        if ($hash === false) {
            throw new Exception('Error generating hash with scrypt.');
        }

        return bin2hex($hash);
    }
}
