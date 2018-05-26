<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 18/05/2018
 * Time: 17:13
 */

namespace Obtao\RecombeeBundle\Serializer;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\Context;

class DynamicJsonTypeFieldHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return array(
            array(
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'dynamic_json_type',
                'method' => 'deserializeFromJSON',
                'class' => 'Obtao\RecombeeBundle\Model\RecombeeApiBulkResponse',
            ),
        );
    }


    /**
     * @param JsonDeserializationVisitor $visitor
     * @param $data
     * @param array $type
     * @param Context $context
     * @return int
     */
    public function deserializeFromJSON(
        JsonDeserializationVisitor $visitor,
        $data,
        array $type,
        Context $context
    ) {
        $message = is_array($data) ? $data['error'] : $data;

        return $data;
    }
}