<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 18/05/2018
 * Time: 10:20
 */

namespace Obtao\RecombeeBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class DeletePurchase extends AbstractModel
{
    /**
     * User who purchased the item
     * @Assert\NotBlank()
     * @JMS\Exclude()
     * @var string
     */
    private $userId;

    /**
     * Purchased item
     * @Assert\NotBlank()
     * @JMS\Exclude()
     * @var string
     */
    private $itemId;

    /**
     * UTC timestamp of the purchase as ISO8601-1 pattern or UTC epoch time.
     * The default value is the current time.
     * @JMS\Exclude()
     * @var \DateTime|null
     */
    private $timestamp;

    public function getMethod(): string
    {
        return 'DELETE';
    }

    public function getUrl(): ?string
    {
        return '/purchases/';
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getItemId(): string
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     */
    public function setItemId(string $itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime|null $timestamp
     */
    public function setTimestamp(?\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function getQueryParameters(): array
    {
        return [
            'userId' => $this->userId,
            'itemId' => $this->itemId,
            'timestamp' => ($this->timestamp) ? $this->timestamp->getTimestamp(): null,
        ];
    }
}