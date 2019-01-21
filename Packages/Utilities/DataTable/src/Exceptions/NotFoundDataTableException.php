<?php

namespace Aut\DataTable\Exceptions;

class NotFoundDataTableException extends \RuntimeException
{
    protected $message = 'This model not registered';
    protected $code = 404;
}