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

class AddPurchase extends AbstractModel
{
    /**
     * User who purchased the item
     * @Assert\NotBlank()
     * @JMS\SerializedName("userId")
     * @JMS\Groups({"post_api"})
     * @var string
     */
    private $userId;

    /**
     * Purchased item
     * @Assert\NotBlank()
     * @JMS\SerializedName("itemId")
     * @JMS\Groups({"post_api"})
     * @var string
     */
    private $itemId;

    /**
     * UTC timestamp of the purchase as ISO8601-1 pattern or UTC epoch time.
     * The default value is the current time.
     * @JMS\Groups({"post_api"})
     * @JMS\Type("DateTime")
     * @var \DateTime|null
     */
    private $timestamp;

    /**
     * Sets whether the given user/item should be created if not present in the database.
     * @JMS\Groups({"post_api"})
     * @JMS\Type("boolean")
     * @var boolean
     */
    private $cascadeCreate;

    /**
     * Amount (number) of purchased items. The default is 1.
     * For example if user-x purchases two item-y during a single order (session...),
     * the amount should equal to 2.
     * @JMS\Groups({"post_api"})
     * @JMS\Type("integer")
     * @var integer|null
     */
    private $amount;

    /**
     * Price paid by the user for the item.
     * If amount is greater than 1, sum of prices of all the items should be given.
     * @JMS\Groups({"post_api"})
     * @JMS\Type("float")
     * @var float|null
     */
    private $price;

    /**
     * Your profit from the purchased item.
     * The profit is natural in e-commerce domain
     * (for example if user-x purchases item-y for $100 and the gross margin is 30 %, then the profit is $30),
     * but is applicable also in other domains
     * (for example at a news company it may be income from displayed advertisement on article page).
     * If amount is greater than 1, sum of profit of all the items should be given.
     * @JMS\Groups({"post_api"})
     * @JMS\Type("float")
     * @var float|null
     */
    private $profit;

    /**
     * AddPurchase constructor.
     *
     * @param string $userId
     * @param string $itemId
     */
    public function __construct(string $userId, string $itemId)
    {
        $this->userId = $userId;
        $this->itemId = $itemId;
        $this->cascadeCreate = false;
    }

    public function getMethod(): string
    {
        return 'POST';
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

    /**
     * @return bool
     */
    public function isCascadeCreate(): bool
    {
        return $this->cascadeCreate;
    }

    /**
     * @param bool $cascadeCreate
     */
    public function setCascadeCreate(bool $cascadeCreate)
    {
        $this->cascadeCreate = $cascadeCreate;
    }

    /**
     * @return int|null
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float|null
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * @param float|null $profit
     */
    public function setProfit($profit)
    {
        $this->profit = $profit;
    }

    public function getBatchParameters(): array
    {
        return [
            'itemId' => $this->itemId,
            'userId' => $this->userId,
            'timestamp' => $this->timestamp,
        ];
    }


}