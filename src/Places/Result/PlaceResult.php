<?php
namespace GoogleMapsApi\Places\Result;

use GoogleMapsApi\Places\Object\PlaceObject;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PredictionResult
 * @package GoogleMapsApi\Places\Result
 */
class PlaceResult
{
    /**
     * @var array $data
     */
    private $data;

    /**
     * @param ResponseInterface $httpResponse
     * @throws BadResponseException
     * @see https://developers.google.com/places/web-service/details#PlaceDetailsResults
     */
    public function __construct(ResponseInterface $httpResponse)
    {
        // Get ResponseInterface content and test it for json
        $data = $httpResponse->getBody()->getContents();
        $data = json_decode($data, true);

        if (false === $data) {
            throw new \InvalidArgumentException(
                sprintf('Response : "%s" has wrong format', $data)
            );
        }

        $options = new OptionsResolver();
        $options->setDefined(['html_attributions', 'result', 'status']);
        $this->data = $options->resolve($data);
    }

    /**
     * @return PlaceObject
     */
    public function getPlaceObject()
    {
        return new PlaceObject($this->data['result']);
    }
}