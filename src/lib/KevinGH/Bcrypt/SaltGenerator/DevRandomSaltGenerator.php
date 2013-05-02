<?php

namespace KevinGH\Bcrypt\SaltGenerator;

/**
 * A salt generator using /dev/random or /dev/urandom.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class DevRandomSaltGenerator extends AbstractSaltGenerator
{
    /**
     * The path to the device.
     *
     * @var string
     */
    private $path;

    /**
     * Sets the path to the device.
     *
     * @param string $path The path.
     */
    public function __construct($path = '/dev/random')
    {
        $this->path = $path;
    }

    /** {@inheritDoc} */
    public function generateSalt()
    {
        $fp = fopen($this->path, 'r');
        $salt = fread($fp, 22);

        fclose($fp);

        return $this->processSalt(base64_encode($salt));
    }

    /** {@inheritDoc} */
    public function isSupported()
    {
        return file_exists($this->path);
    }
}
