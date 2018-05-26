<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 11/05/2018
 * Time: 17:21
 */

namespace Obtao\RecombeeBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class GetItemValues extends AbstractModel
{
    /**
     * @JMS\Exclude()
     * @Assert\NotBlank()
     * @var string
     */
    private $itemId;

    public function __construct(string $itemId)
    {
        $this->itemId = $itemId;
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    /** @inheritdoc */
    public function getUrl(): ?string
    {
        return sprintf('/items/%s', $this->itemId);
    }

}