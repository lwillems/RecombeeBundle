<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 04/05/2018
 * Time: 16:12
 */

namespace Obtao\RecombeeBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class SetItemValues extends AbstractModel
{
    /**
     * @JMS\Exclude()
     * @Assert\NotBlank()
     * @var string
     */
    private $itemId;

    /**
     * @JMS\Inline()
     * @JMS\Type("Obtao\RecombeeBundle\Model\Item")
     * @JMS\Groups({"post_api"})
     * @Assert\NotNull()
     * @Assert\Valid()
     */
    private $body;

    public function __construct(HasSkuInterface $item)
    {
        $this->itemId = $item->getSku();
        $this->body = $item;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    /** @inheritdoc */
    public function getUrl(): ?string
    {
        return sprintf('/items/%s', $this->itemId);
    }

    /**
     * @param string $itemId
     */
    public function setItemId(string $itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

}