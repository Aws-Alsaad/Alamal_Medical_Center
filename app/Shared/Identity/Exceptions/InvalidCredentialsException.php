<?php

namespace App\Shared\Identity\Exceptions;

use RuntimeException;

class InvalidCredentialsException extends RuntimeException
{
    // Rendered centrally using the approved API error contract.
}
