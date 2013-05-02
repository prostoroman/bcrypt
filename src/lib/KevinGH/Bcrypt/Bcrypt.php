<?php

namespace KevinGH\Bcrypt;

use KevinGH\Bcrypt\Exception\ImplementationNotSupportedException;
use KevinGH\Bcrypt\Exception\InvalidCostException;
use KevinGH\Bcrypt\Exception\InvalidEncodedStringException;
use KevinGH\Bcrypt\Exception\InvalidImplementationException;
use KevinGH\Bcrypt\Exception\InvalidSaltException;
use KevinGH\Bcrypt\Exception\MissingSaltException;
use KevinGH\Bcrypt\SaltGenerator\SaltGeneratorInterface;
use KevinGH\Bcrypt\SaltGenerator\CryptoApiSaltGenerator;
use KevinGH\Bcrypt\SaltGenerator\DevRandomSaltGenerator;
use KevinGH\Bcrypt\SaltGenerator\McryptSaltGenerator;
use KevinGH\Bcrypt\SaltGenerator\MtRandSaltGenerator;
use KevinGH\Bcrypt\SaltGenerator\OpenSslSaltGenerator;

/**
 * The best supported Blowfish implemenation.
 *
 * @var string
 */
define(
    'BLOWFISH_IMPLEMENTATION',
    version_compare(phpversion(), '5.3.7', '>=')
        ? '2y'
        : '2a'
);

/**
 * Encodes strings using Blowfish.
 *
 * This class uses the configured implementation, cost, and salt to encode
 * one or more strings using Blowfish. While the instance is re-usable, it
 * is not recommended to be used for more than a single string without
 * regenerating the salt.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Bcrypt
{
    /**
     * The cost.
     *
     * @var integer
     */
    private $cost = 10;

    /**
     * The implementation to use.
     *
     * @var string
     */
    private $implementation = BLOWFISH_IMPLEMENTATION;

    /**
     * The salt.
     *
     * @var string
     */
    private $salt;

    /**
     * The registered salt generators.
     *
     * @var array
     */
    private $saltGenerators = array();

    /**
     * Sets the implementation to use.
     *
     * @param boolean $broken Force broken implementation?
     */
    public function __construct($broken = false)
    {
        if ($broken) {
            $this->implementation = '2a';
        }
    }

    /**
     * Encodes the raw string using Blowfish.
     *
     * @param string $raw The raw string.
     *
     * @return string The encoded string.
     */
    public function __invoke($raw)
    {
        return crypt($raw, $this->getCryptSalt());
    }

    /**
     * Adds a new salt generator.
     *
     * @param SaltGeneratorInterface $saltGenerator The salt generator.
     */
    public function addSaltGenerator(SaltGeneratorInterface $saltGenerator)
    {
        $this->saltGenerators[] = $saltGenerator;
    }

    /**
     * Creates a new and configured instance of {@link Bcrypt}.
     *
     * @param boolean $broken Force broken implementation?
     *
     * @return Bcrypt A new instance.
     */
    public static function create($broken = false)
    {
        $bcrypt = new self($broken);

        $bcrypt->addSaltGenerator(new McryptSaltGenerator);
        $bcrypt->addSaltGenerator(new OpenSslSaltGenerator);
        $bcrypt->addSaltGenerator(new DevRandomSaltGenerator('/dev/urandom'));
        $bcrypt->addSaltGenerator(new CryptoApiSaltGenerator);

        return $bcrypt;
    }

    /**
     * Generates a new salt.
     *
     * @return string A new salt.
     */
    public function generateSalt()
    {
        foreach ($this->saltGenerators as $saltGenerator) {
            if ($saltGenerator->isSupported()) {
                return $saltGenerator->generateSalt();
            }
        }

        $fallback = new MtRandSaltGenerator();

        return $fallback->generateSalt();
    }

    /**
     * Returns the cost.
     *
     * @return integer The cost.
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Returns the salt used by crypt() to generate the encoded string.
     *
     * @return string The salt.
     *
     * @throws MissingSaltException If no salt is set.
     */
    public function getCryptSalt()
    {
        if (null === $this->salt) {
            throw new MissingSaltException();
        }

        return sprintf(
            '$%s$%02d$%s',
            $this->implementation,
            $this->cost,
            $this->salt
        );
    }

    /**
     * Returns the implementation.
     *
     * @return string The implementation.
     */
    public function getImplementation()
    {
        return $this->implementation;
    }

    /**
     * Returns the salt.
     *
     * @return string The salt.
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets the cost.
     *
     * @param integer $cost The cost.
     *
     * @throws InvalidCostException If the cost is invalid.
     */
    public function setCost($cost)
    {
        $cost = (int) $cost;

        if ((4 > $cost) || (31 < $cost)) {
            throw new InvalidCostException($cost);
        }

        $this->cost = $cost;
    }

    /**
     * Sets the implementation, cost, and salt using a Blowfish encoded string.
     *
     * @param string $encoded The encoded string.
     *
     * @throws InvalidEncodedStringException If the encoded string is invalid.
     */
    public function setEncoded($encoded)
    {
        if (false == preg_match(
            '/^\$2[axy]\$\d{1,2}\$[a-zA-Z0-9\.\/]{22}[a-zA-Z0-9\.\/]+$/',
            $encoded
        )){
            throw new InvalidEncodedStringException($encoded);
        }

        $parts = explode('$', $encoded);

        array_shift($parts);

        $this->setCost($parts[1]);
        $this->setImplementation($parts[0]);
        $this->setSalt($parts[2]);
    }

    /**
     * Sets the implementation.
     *
     * @param string $implementation The implementation.
     *
     * @throws ImplementationNotSupportedException If the implementation is not supported.
     * @throws InvalidImplementationException      If the implementation is invalid.
     */
    public function setImplementation($implementation)
    {
        switch ($implementation) {
            case '2y':
            case '2x':
                if ('2y' !== BLOWFISH_IMPLEMENTATION) {
                    throw new ImplementationNotSupportedException($implementation);
                }
            case '2a':
                break;
            default:
                throw new InvalidImplementationException($implementation);
        }

        $this->implementation = $implementation;
    }

    /**
     * Sets the salt.
     *
     * @param string $salt The salt.
     *
     * @throws InvalidSaltException If the salt is not valid.
     */
    public function setSalt($salt)
    {
        if (false == preg_match('/^[a-zA-Z0-9\.\/]{22,}$/', $salt)) {
            throw new InvalidSaltException($salt);
        }

        $this->salt = substr($salt, 0, 22);
    }
}
