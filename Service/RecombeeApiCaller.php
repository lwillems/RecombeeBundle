<?php
/**
 * Created by PhpStorm.
 * User: laurentwillems
 * Date: 30/04/2018
 * Time: 19:00
 */

namespace Obtao\RecombeeBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Obtao\RecombeeBundle\Exception\BulkRecombeeApiException;
use Obtao\RecombeeBundle\Exception\RecombeeApiException;
use Obtao\RecombeeBundle\Exception\RecombeeProductException;
use Obtao\RecombeeBundle\Model\AbstractModel;
use Obtao\RecombeeBundle\Model\Batch;
use Obtao\RecombeeBundle\Model\BatchInterface;
use Obtao\RecombeeBundle\Model\RecombeeApiBulkResponse;
use Obtao\RecombeeBundle\Model\RecombeeApiError;
use Obtao\RecombeeBundle\Model\RequestInterface;
use Obtao\RecombeeBundle\Serializer\SerializationGroups;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class RecombeeApiCaller
{
    const API_BASE_URL = 'https://rapi.recombee.com';
    /**
     * @var Client
     */
    private $client;
    /**
     * @var string
     */
    private $apiToken;
    /**
     * @var string
     */
    private $apiDatabaseName;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * RecombeeApiCaller constructor.
     *
     * @param string $apiToken
     * @param string $apiDatabaseName
     * @param SerializerInterface $serializer
     */
    public function __construct(
        string $apiToken,
        string $apiDatabaseName,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ){
        $this->apiToken = $apiToken;
        $this->apiDatabaseName = $apiDatabaseName;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        if (!$this->client instanceof Client) {
            $this->client = new Client(
                self::API_BASE_URL,
                [
                    'request.options' =>
                        [
                            'headers' =>
                                [
                                    'Accept' => 'application/json',
                                    'Content-Type' => 'application/json'
                                ]
                        ]
                ]
            );
        }

        return $this->client;
    }

    /**
     * Build HashMac signed recombee API url
     *
     * @param AbstractModel $request
     * @return string
     */
    private function getHashMacUrl(AbstractModel $request)
    {
        $uri = sprintf(
            '/%s%s%shmac_timestamp=%s',
            $this->apiDatabaseName,
            $request->getUrl(),
            (sizeof($request->getQueryParameters()) > 0) ? '?'. http_build_query($request->getQueryParameters()) .'&' : '?',
            time()
        );
        $sign = hash_hmac('sha1', $uri, $this->apiToken);
        $uri .= '&hmac_sign='.$sign;

        return $uri;
    }

    /**
     * Send a request to Recombee API
     *
     * @param AbstractModel $model
     * @throws BulkRecombeeApiException
     * @throws RecombeeApiException
     *
     * @return string json response from API
     */
    public function sendToApi(AbstractModel $model)
    {
        $validationsErrors = $this->validator->validate($model);
        if (sizeof($validationsErrors) > 0) {
            throw new RecombeeProductException((string)$validationsErrors);
        }
        $uri = $this->getHashMacUrl($model);
        $context = $this->initSerializationContext();
        if (!$model instanceof BatchInterface) {
            $jsonData = $this->serializer->serialize(
                $model,
                'json',
                $context
            );
        } else {
            $batches = array_map(
                function (AbstractModel $item) use ($model) {
                    $childContext = $this->initSerializationContext();
                    $batchContext = $this->initSerializationContext(SerializationGroups::BATCH);
                    // build batch fields using batch context
                    $child = $this->serializer->toArray($item, $batchContext);
                    // redefine context for child
                    $child['params'] = $this->serializer->toArray(
                        $item,
                        $childContext
                    );

                    $child['params'] += $item->getQueryParameters();

                    return $child;
                },
                $model->getRequests()
            );

            $jsonData = json_encode(
                [
                    'requests' => $batches
                ]
            );
        }

        try {
            $apiRequest = $this->getClient()->createRequest(
                $model->getMethod(),
                $uri,
                null,
                $jsonData
            );
            $response = $apiRequest->send();

            // particular case of batch
            if ($model instanceof BatchInterface) {
                $apiBulkResponse = $this->serializer->deserialize(
                    $response->getBody(),
                    'array<Obtao\RecombeeBundle\Model\RecombeeApiBulkResponse>',
                    'json'
                );

                $errors = array_filter(
                    $apiBulkResponse,
                    function (RecombeeApiBulkResponse $response) {
                        return (!in_array($response->getCode(), [Response::HTTP_CREATED, Response::HTTP_OK]));
                    }
                );
                $errorCount = sizeof($errors);
                if ($errorCount > 0) {
                    throw new BulkRecombeeApiException(
                        sprintf(
                            'There is %d errors with bulk, original error : %s',
                            $errorCount,
                            $response->getBody(true)
                        )
                    );
                }
            }

            return $response->getBody(true);
        } catch (BadResponseException | ClientErrorResponseException $e) {
            $apiResponse = $e->getResponse();
            /** @var RecombeeApiError $apiErrorMessage */
            $apiErrorMessage = $this->serializer->deserialize(
                $apiResponse->getBody(),
                RecombeeApiError::class,
                'json'
            );

            throw new RecombeeApiException(
                $apiErrorMessage->getStatusCode() ?? $apiResponse->getStatusCode(),
                $apiErrorMessage->getMessage() ?? $apiErrorMessage->getError()
            );
        }
    }

    /**
     * @param string $groupName
     *
     * @return SerializationContext
     */
    private function initSerializationContext($groupName = SerializationGroups::POST_TO_API)
    {
        $context = SerializationContext::create()->setGroups([$groupName]);

        return $context;
    }
}