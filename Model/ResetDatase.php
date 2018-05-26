<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 04/05/2018
 * Time: 15:45
 */

namespace Obtao\RecombeeBundle\Model;

class ResetDatase extends AbstractModel
{
    public function getMethod(): string
    {
        return 'DELETE';
    }

    public function getUrl(): ?string
    {
        return '/';
    }

}