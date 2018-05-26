<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 04/05/2018
 * Time: 14:15
 */

namespace Obtao\RecombeeBundle\Model;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

class AddItemProperty extends AbstractModel implements DefinePropertyInterface
{
    /**
     * @Assert\NotBlank()
     * @JMS\Exclude()
     * @var string
     */
    protected $propertyName;

    /**
     * @JMS\Exclude()
     * @Assert\NotBlank()
     * @Assert\Choice({"int", "double", "string", "boolean", "timestamp", "set", "image", "imageList"})
     * @var string
     */
    protected $type;

    public function __construct(string $propertyName, string $type)
    {
        $this->propertyName = $propertyName;
        $this->type = $type;
    }

    /** @inheritdoc */
    public function getUrl(): ?string
    {
        return sprintf('/items/properties/%s', $this->propertyName);
    }

    /** @inheritdoc */
    public function getMethod(): string
    {
        return 'PUT';
    }

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     */
    public function setPropertyName(string $propertyName)
    {
        $this->propertyName = $propertyName;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getQueryParameters(): array
    {
        return [
            'type' => $this->type,
        ];
    }

    public function getBatchParameters(): array
    {
        return $this->getQueryParameters();
    }
}