<?php

namespace KevinGH\Bcrypt\Exception;

use InvalidArgumentException;

/**
 * This exception is used if the cost was either invalid, was less than 4,
 * or was greater than 32.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class InvalidCostException extends InvalidArgumentException
{
    /**
     * The invalid cost.
     *
     * @var string
     */
    private $cost;

    /**
     * Sets the invalid cost.
     *
     * @param string $cost The invalid cost.
     */
    public function __construct($cost)
    {
        $this->cost = $cost;
    }

    /**
     * Returns the invalid cost.
     *
     * @return string The invalid cost.
     */
    public function getCost()
    {
        return $this->cost;
    }
}
