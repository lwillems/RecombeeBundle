<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 18/05/2018
 * Time: 09:26
 */

namespace Obtao\RecombeeBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class SetUserValues extends AbstractModel
{
    /**
     * @JMS\Exclude()
     * @Assert\NotBlank()
     * @var string
     */
    private $userId;

    /**
     * @JMS\Inline()
     * @JMS\Type("Obtao\RecombeeBundle\Model\User")
     * @JMS\Groups({"post_api"})
     * @Assert\NotNull()
     * @Assert\Valid()
     */
    private $body;

    public function __construct(HasSkuInterface $user)
    {
        $this->userId = $user->getSku();
        $this->body = $user;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    /** @inheritdoc */
    public function getUrl(): ?string
    {
        return sprintf('/users/%s', $this->userId);
    }

    /**
     * @param string $itemId
     */
    public function setUserId(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
}