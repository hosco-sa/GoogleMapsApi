<?php
namespace GoogleMapsApi\Places\Result;

use GoogleMapsApi\Places\Object\PredictionObject;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PlaceAutocompleteResult
 * @package GoogleMapsApi\Places\Result
 */
class PlaceAutocompleteResult extends AbstractResult
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param ResponseInterface $httpResponse
     * @param string $language
     * @throws BadResponseException
     * @see https://developers.google.com/places/web-service/autocomplete#place_autocomplete_responses
     * @throws \Exception
     */
    public function __construct(ResponseInterface $httpResponse, $language)
    {
        // Get ResponseInterface content and test it for json
        $jsonData = (string) $httpResponse->getBody();
        $data     = json_decode($jsonData, true);

        // Append language parameter to data
        $data['language'] = $language;

        if (false === $data) {
            throw new \InvalidArgumentException(
                sprintf('Response : "%s" has wrong format', $data)
            );
        }

        // Put it through options for a clean response
        $options = new OptionsResolver();
        $options->setDefined(['error_message']);
        $options->setRequired(['status', 'predictions', 'language']);
        $this->data = $options->resolve($data);

        // Check request status
        if (!$this->checkRequestStatus()) {
            throw new \Exception(
                sprintf('Request failed "%s"', $jsonData)
            );
        }
    }

    /**
     * Get predictions from query
     * @return PredictionObject[]
     */
    public function getPredictions()
    {
        $rpredictions = [];
        foreach ($this->data['predictions'] as $prediction) {
            // Append language to prediction
            $prediction['language'] = $this->data['language'];

            $rpredictions[] = new PredictionObject($prediction);
        }

        return $rpredictions;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->data['status'];
    }
}
