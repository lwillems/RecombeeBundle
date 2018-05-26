<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 11/05/2018
 * Time: 10:23
 */

namespace Obtao\RecombeeBundle\Model;

interface HasSkuInterface
{
    /**
     * @return int
     */
    public function getSku(): int;
    /**
     * @param int $sku
     */
    public function setSku(int $sku);
}