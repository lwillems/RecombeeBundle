<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 18/05/2018
 * Time: 14:12
 */

namespace Obtao\RecombeeBundle\Helper;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Obtao\RecombeeBundle\Model\Batch;
use Obtao\RecombeeBundle\Model\DefinePropertyInterface;
use Obtao\RecombeeBundle\Model\HasSkuInterface;
use Obtao\RecombeeBundle\Serializer\SerializationGroups;

class BatchBuilder
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * BatchBuilder constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Return a batch of DefinePropertyInterface classes
     *
     * @param HasSkuInterface $model
     * @param string $className
     *
     * @return Batch
     */
    public function buildBatchOfProperties(HasSkuInterface $model, string $className): Batch
    {
        $batch = new Batch();

        $context = SerializationContext::create()->setGroups([SerializationGroups::DEFINE_PROPERTY]);

        $itemArray = $this->serializer->toArray($model, $context);

        $interfaces = class_implements($className);

        if (sizeof($interfaces) == 0) {
            throw new \LogicException(
                sprintf(
                    'You have to use a class which implements %s for this method %s',
                    DefinePropertyInterface::class,
                    __CLASS__ . __METHOD__
                )
            );
        }

        foreach ($itemArray as $key => $value) {
            switch (gettype($value)) {
                case 'integer':
                    $batch->addRequest(new $className($key, 'int'));
                    break;
                case 'array':
                    $batch->addRequest(new $className($key, 'set'));
                    break;
                case 'boolean':
                case 'double':
                case 'string':
                    $batch->addRequest(new $className($key, gettype($value)));
                    break;
                default:
                    throw new \LogicException(
                        sprintf('type not found for key %s', $key)
                    );
                    break;
            }
        }

        return $batch;
    }
}