<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 04/05/2018
 * Time: 16:36
 */

namespace Obtao\RecombeeBundle\Model;
use JMS\Serializer\Annotation as JMS;

class RecombeeApiError
{
    /**
     * @JMS\Type("string")
     * @var string|null
     */
    private $message;

    /**
     * @JMS\Type("integer")
     * @var integer|null
     */
    private $statusCode;

    /**
     * @JMS\Type("string")
     * @var string|null
     */
    private $error;

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message)
    {
        $this->message = $message;
    }

    /**
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * @param int|null $statusCode
     */
    public function setStatusCode(?int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return null|string
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @param null|string $error
     */
    public function setError(?string $error)
    {
        $this->error = $error;
    }
}