<?php
namespace GoogleMapsApi\Places\Result;

use GoogleMapsApi\Places\Object\PlaceObject;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PredictionResult
 * @package GoogleMapsApi\Places\Result
 */
class PlaceResult extends AbstractResult
{
    /**
     * @var array $data
     */
    private $data;

    /**
     * @param ResponseInterface $httpResponse
     * @param string $language
     * @throws BadResponseException
     * @see https://developers.google.com/places/web-service/details#PlaceDetailsResults
     * @throws \Exception
     */
    public function __construct(ResponseInterface $httpResponse, $language)
    {
        // Get ResponseInterface content and test it for json
        $jsonData = $httpResponse->getBody()->getContents();
        $data     = json_decode($jsonData, true);

        // Append language to result
        $data['language'] = $language;

        if (false === $data) {
            throw new \InvalidArgumentException(
                sprintf('Response : "%s" has wrong format', $data)
            );
        }

        $options = new OptionsResolver();
        $options->setRequired(['language']);
        $options->setDefined(['error_message', 'html_attributions', 'result', 'status']);
        $this->data = $options->resolve($data);

        // Set language as part of result
        $this->data['result']['language'] = $language;

        // Check request status
        if (!$this->checkRequestStatus()) {
            throw new \Exception(
                sprintf('Request failed "%s"', $jsonData)
            );
        }
    }

    /**
     * @return PlaceObject
     */
    public function getPlaceObject()
    {
        return new PlaceObject($this->data['result']);
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->data['status'];
    }
}