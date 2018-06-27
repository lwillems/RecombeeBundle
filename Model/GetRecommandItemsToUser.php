<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 08/06/2018
 * Time: 11:57
 */

namespace Obtao\RecombeeBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class GetRecommandItemsToUser extends AbstractModel
{
    /**
     * @JMS\Exclude()
     * @Assert\NotBlank()
     * @var string
     */
    private $userId;

    /**
     * Number of items to be recommended (N for the top-N recommendation).
     *
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @JMS\Type("integer")
     * @JMS\Groups({"post_api"})
     * @var integer
     */
    private $count;

    /**
     * Boolean-returning ReQL expression which allows you to filter
     * recommended items based on the values of their attributes.
     * @JMS\Type("string")
     * @JMS\Groups({"post_api"})
     * @var string|null
     */
    private $filter;

    /**
     * Number-returning ReQL expression which allows you to boost recommendation
     * rate of some items based on the values of their attributes.
     * @JMS\Type("string")
     * @JMS\Groups({"post_api"})
     * @var string|null
     */
    private $booster;

    /**
     * If the user does not exist in the database,
     * returns a list of non-personalized
     * recommendations and creates the user in the database.
     * This allows for example rotations in the following
     * recommendations for that user,
     * as the user will be already known to the system.
     * @Assert\Type("boolean")
     * @JMS\SerializedName("cascadeCreated")
     * @JMS\Groups({"post_api"})
     * @JMS\Type("boolean")
     * @var boolean
     */
    private $cascadeCreate;

    /**
     * Scenario defines a particular application of recommendations.
     * It can be for example â€œhomepageâ€, â€œcartâ€ or â€œemailingâ€.
     * You can see each scenario in the UI separately,
     * so you can check how well each application performs.
     * The AI which optimizes models in order to get the best results
     * may optimize different scenarios separately
     * or even use different models in each of the scenarios.
     * @JMS\Type("string")
     * @JMS\Groups({"post_api"})
     * @var string|null
     *
     */
    private $scenario;

    /**
     * With returnProperties=true,
     * property values of the recommended items are returned along
     * with their IDs in a JSON dictionary.
     * The acquired property values
     * can be used for easy displaying of the recommended items to the user.
     * @Assert\Type("boolean")
     * @JMS\SerializedName("returnProperties")
     * @JMS\Groups({"post_api"})
     * @JMS\Type("boolean")
     * @var boolean
     */
    private $returnProperties;

    /**
     * Allows to specify, which properties should be returned
     * when returnProperties=true is set.
     * The properties are given as a comma-separated list.
     * @Assert\Type("array")
     * @JMS\SerializedName("includedProperties")
     * @JMS\Groups({"post_api"})
     * @JMS\Type("array")
     * @var array|null
     */
    private $includedProperties;

    /**
     * Expert option Real number from [0.0, 1.0]
     * which determines how much mutually dissimilar should the recommended items be.
     * The default value is 0.0, i.e., no diversification.
     * Value 1.0 means maximal diversification.
     * @Assert\Type("integer")
     * @JMS\Groups({"post_api"})
     * @JMS\Type("integer")
     * @var integer|null
     */
    private $diversity;

    /**
     * Expert option Specifies the threshold of how much
     * relevant must the recommended items be to the user.
     * Possible values one of: â€œlowâ€, â€œmediumâ€, â€œhighâ€.
     * The default value is â€œlowâ€,
     * meaning that the system attempts to recommend number of items
     * equal to count at any cost.
     * If there are not enough data (such as interactions or item properties),
     * this may even lead to bestseller-based recommendations
     * to be appended to reach the full count.
     * This behavior may be suppressed by using â€œmediumâ€ or â€œhighâ€ values.
     * In such case, the system only recommends items
     * of at least the requested relevancy,
     * and may return less than count items
     * when there is not enough data to fulfill it.
     * @Assert\Choice({"low", "medium", "high"})
     * @JMS\SerializedName("minRelevance")
     * @JMS\Groups({"post_api"})
     * @JMS\Type("string")
     * @var string|null
     */
    private $minRelevance;

    /**
     * Expert option If your users browse the system in real-time,
     * it may easily happen that you wish to offer them recommendations
     * multiple times. Here comes the question:
     * how much should the recommendations change?
     * Should they remain the same, or should they rotate?
     * Recombee API allows you to control this per-request in backward fashion.
     * You may penalize an item for being recommended in the near past.
     * For the specific user, rotationRate=1 means maximal rotation, rotationRate=0
     * means absolutely no rotation.
     * You may also use, for example rotationRate=0.2
     * for only slight rotation of recommended items. Default: 0.1.
     * @Assert\Type("integer")
     * @JMS\SerializedName("rotationRate")
     * @JMS\Groups({"post_api"})
     * @JMS\Type("integer")
     * @var integer|null
     */
    private $rotationRate;

    /**
     * Expert option Taking rotationRate into account,
     * specifies how long time it takes to an item to recover
     * from the penalization. For example, rotationTime=7200.0
     * means that items recommended less than 2 hours ago are penalized.
     * Default: 7200.0.
     * @Assert\Type("integer")
     * @JMS\SerializedName("rotationTime")
     * @JMS\Groups({"post_api"})
     * @JMS\Type("integer")
     * @var integer|null
     */
    private $rotationTime;

    public function __construct(string $userId, int $expectedRecommandation = 10)
    {
        $this->userId = $userId;
        $this->cascadeCreate = false;
        $this->returnProperties = true;
        $this->count = $expectedRecommandation;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUrl(): ?string
    {
        return sprintf('/recomms/users/%s/items/', $this->userId);
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
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return null|string
     */
    public function getFilter(): ?string
    {
        return $this->filter;
    }

    /**
     * @param null|string $filter
     */
    public function setFilter(?string $filter): void
    {
        $this->filter = $filter;
    }

    /**
     * @return null|string
     */
    public function getBooster(): ?string
    {
        return $this->booster;
    }

    /**
     * @param null|string $booster
     */
    public function setBooster(?string $booster): void
    {
        $this->booster = $booster;
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
    public function setCascadeCreate(bool $cascadeCreate): void
    {
        $this->cascadeCreate = $cascadeCreate;
    }

    /**
     * @return null|string
     */
    public function getScenario(): ?string
    {
        return $this->scenario;
    }

    /**
     * @param null|string $scenario
     */
    public function setScenario(?string $scenario): void
    {
        $this->scenario = $scenario;
    }

    /**
     * @return bool
     */
    public function isReturnProperties(): bool
    {
        return $this->returnProperties;
    }

    /**
     * @param bool $returnProperties
     */
    public function setReturnProperties(bool $returnProperties): void
    {
        $this->returnProperties = $returnProperties;
    }

    /**
     * @return array|null
     */
    public function getIncludedProperties(): ?array
    {
        return $this->includedProperties;
    }

    /**
     * @param array|null $includedProperties
     */
    public function setIncludedProperties(?array $includedProperties): void
    {
        $this->includedProperties = $includedProperties;
    }

    /**
     * @return int|null
     */
    public function getDiversity(): ?int
    {
        return $this->diversity;
    }

    /**
     * @param int|null $diversity
     */
    public function setDiversity(?int $diversity): void
    {
        $this->diversity = $diversity;
    }

    /**
     * @return null|string
     */
    public function getMinRelevance(): ?string
    {
        return $this->minRelevance;
    }

    /**
     * @param null|string $minRelevance
     */
    public function setMinRelevance(?string $minRelevance): void
    {
        $this->minRelevance = $minRelevance;
    }

    /**
     * @return int|null
     */
    public function getRotationRate(): ?int
    {
        return $this->rotationRate;
    }

    /**
     * @param int|null $rotationRate
     */
    public function setRotationRate(?int $rotationRate): void
    {
        $this->rotationRate = $rotationRate;
    }

    /**
     * @return int|null
     */
    public function getRotationTime(): ?int
    {
        return $this->rotationTime;
    }

    /**
     * @param int|null $rotationTime
     */
    public function setRotationTime(?int $rotationTime): void
    {
        $this->rotationTime = $rotationTime;
    }



}