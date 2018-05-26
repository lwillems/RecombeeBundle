<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 04/05/2018
 * Time: 15:52
 */

namespace Obtao\RecombeeBundle\Model;
use JMS\Serializer\Annotation as JMS;

abstract class AbstractModel
{
    /**
     * @JMS\Exclude()
     */
    protected $queryParameters = [];

    /**
     * @JMS\Groups({"batch"})
     * @JMS\VirtualProperty()
     */
    abstract public function getMethod(): string;
    /**
     * @JMS\Groups({"batch"})
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("path")
     */
    abstract public function getUrl(): ?string;

    /**
     * @return array
     */
    public function getQueryParameters(): array
    {
        return $this->queryParameters;
    }
}