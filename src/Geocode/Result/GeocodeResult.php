<?php
namespace GoogleMapsApi\Geocode\Result;

use GoogleMapsApi\Geocode\Object\GeocodeObject;
use Guzzle\Http\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PredictionResult
 * @package GoogleMapsApi\Places\Result
 */
class GeocodeResult extends AbstractResult
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
        $jsonData = (string) $httpResponse->getBody();
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
        $options->setDefined(['error_message', 'html_attributions', 'results', 'status']);
        $this->data = $options->resolve($data);

        // Set language as part of results
        if (isset($this->data['results'])) {
            foreach ((array) $this->data['results'] as $key => $value) {
                $this->data['results'][$key]['language'] = $language;
            }
        }
        $this->data['language'] = $language;

        // Check request status
        if (!$this->checkRequestStatus()) {
            throw new \Exception(
                sprintf('Request failed "%s"', $jsonData)
            );
        }
    }

    /**
     * @return GeocodeObject
     */
    public function getPlaceObject()
    {
        return new GeocodeObject(current($this->data['results']));
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->data['status'];
    }
}
