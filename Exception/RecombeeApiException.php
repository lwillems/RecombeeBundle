<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 04/05/2018
 * Time: 16:35
 */

namespace Obtao\RecombeeBundle\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RecombeeApiException extends HttpException
{
    public function __construct($statusCode, $message = null, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}