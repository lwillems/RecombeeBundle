<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 18/05/2018
 * Time: 09:29
 */

namespace Obtao\RecombeeBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class User implements HasSkuInterface
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
     * @JMS\Type("string")
     * @JMS\Groups({"post_api", "define_property"})
     * @var string|null $nickName
     */
    private $nickName;

    /**
     * @JMS\Type("string")
     * @Assert\Country()
     * @JMS\Groups({"post_api", "define_property"})
     * @var string|null $originCountry
     */
    private $originCountry;

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
     * @return null|string
     */
    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    /**
     * @param null|string $nickName
     */
    public function setNickName(?string $nickName): void
    {
        $this->nickName = $nickName;
    }

    /**
     * @return null|string
     */
    public function getOriginCountry(): ?string
    {
        return $this->originCountry;
    }

    /**
     * @param null|string $originCountry
     */
    public function setOriginCountry(?string $originCountry): void
    {
        $this->originCountry = $originCountry;
    }
}