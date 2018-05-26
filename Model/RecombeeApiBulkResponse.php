<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 11/05/2018
 * Time: 14:05
 */

namespace Obtao\RecombeeBundle\Model;

use JMS\Serializer\Annotation as JMS;


class RecombeeApiBulkResponse
{
    /**
     * Http status code
     * @JMS\Type("integer")
     * @var int $code
     */
    private $code;

    /**
     * @JMS\Type("dynamic_json_type")
     */
    private $json;

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @param mixed $json
     */
    public function setJson($json)
    {
        $this->json = $json;
    }
}