<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 11/05/2018
 * Time: 17:39
 */

namespace Obtao\RecombeeBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class AddUser extends AbstractModel
{
    /**
     * @Assert\NotBlank()
     * @JMS\Exclude()
     * @var string
     */
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /** @inheritdoc */
    public function getUrl(): ?string
    {
        return sprintf('/users/%s', $this->userId);
    }

    /** @inheritdoc */
    public function getMethod(): string
    {
        return 'PUT';
    }
}