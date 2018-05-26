<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 18/05/2018
 * Time: 18:06
 */

namespace Obtao\RecombeeBundle\Model;


interface IsBatchable
{
    public function getBatchParameters(): array;
}