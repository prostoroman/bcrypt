<?php

namespace KevinGH\Bcrypt\Exception;

use LogicException;

/**
 * This exception is thrown if no salt was set.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class MissingSaltException extends LogicException
{
}
