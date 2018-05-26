<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 11/05/2018
 * Time: 11:49
 */

namespace Obtao\RecombeeBundle\Model;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class Batch extends AbstractModel implements BatchInterface
{
    /**
     * @Assert\Valid()
     * @Assert\Count(min="1")
     * @JMS\Type("array<Obtao\RecombeeBundle\Model\AbstractModel>")
     * @JMS\Groups({"batch"})
     * @var AbstractModel[]
     */
    private $requests = [];

    /**
     * @return array
     */
    public function getRequests(): array
    {
        return $this->requests;
    }

    /**
     * @param array $requests
     */
    public function setRequests(array $requests)
    {
        $this->requests = $requests;
    }

    public function addRequest(AbstractModel $request)
    {
        $this->requests[] = $request;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function getUrl(): ?string
    {
        return '/batch/';
    }


}