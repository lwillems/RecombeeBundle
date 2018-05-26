<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 25/05/2018
 * Time: 17:51
 */

namespace Obtao\RecombeeBundle\Model;

interface DefinePropertyInterface
{
    /**
     * @return string
     */
    public function getPropertyName(): string;

    /**
     * @param string $propertyName
     */
    public function setPropertyName(string $propertyName);
}