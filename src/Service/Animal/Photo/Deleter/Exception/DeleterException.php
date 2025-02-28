<?php

namespace App\Service\Animal\Photo\Deleter\Exception;

use Exception;

class DeleterException extends Exception {
    public function __construct(string $message, ?int $code = null, ?Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}