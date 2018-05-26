<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 30/03/2018
 * Time: 15:04
 */

namespace Obtao\RecombeeBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class Item implements HasSkuInterface
{
    /**
     * @JMS\Type("boolean")
     * @JMS\SerializedName("!cascadeCreate")
     * @JMS\Groups({"post_api"})
     * @var boolean
     */
    private $cascadeCreate = true;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @JMS\Type("integer")
     * @JMS\Groups({"post_api", "define_property"})
     * @var integer $sku
     */
    private $sku;

    /**
     * @Assert\NotNull()
     * @Assert\Type("integer")
     * @var integer $quantity
     * @JMS\Groups({"post_api", "define_property"})
     */
    private $quantity;

    /**
     * @return int
     */
    public function getSku(): int
    {
        return $this->sku;
    }

    /**
     * @param int $sku
     */
    public function setSku(int $sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }
}