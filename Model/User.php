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
     * @var string|null $firstName
     */
    private $firstName;

    /**
     * @JMS\Type("string")
     * @JMS\Groups({"post_api", "define_property"})
     * @var string|null $lastName
     */
    private $lastName;

    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     * @JMS\Type("string")
     * @JMS\Groups({"post_api", "define_property"})
     * @var string $email
     */
    private $email;

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
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null
     */
    public function setLastName(?string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
}