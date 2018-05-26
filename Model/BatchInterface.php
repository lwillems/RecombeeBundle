<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 11/05/2018
 * Time: 12:45
 */

namespace Obtao\RecombeeBundle\Model;

interface BatchInterface
{
    /**
     * @return array
     */
    public function getRequests(): array;

    /**
     * @param array $requests
     */
    public function setRequests(array $requests);

    /**
     * @param AbstractModel $request
     */
    public function addRequest(AbstractModel $request);
}