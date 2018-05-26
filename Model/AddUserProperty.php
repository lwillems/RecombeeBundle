<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 18/05/2018
 * Time: 09:22
 */

namespace Obtao\RecombeeBundle\Model;


class AddUserProperty extends AddItemProperty implements DefinePropertyInterface
{
    /** @inheritdoc */
    public function getUrl(): ?string
    {
        return sprintf('/users/properties/%s', $this->propertyName);
    }
}