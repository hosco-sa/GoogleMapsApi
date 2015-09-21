<?php
namespace GoogleMapsApi\Places\Result;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PlaceAutocompleteResult
 * @package GoogleMapsApi\Places\Result
 */
class PlaceAutocompleteResult
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param ResponseInterface $httpResponse
     * @throws BadResponseException
     * @see https://developers.google.com/places/web-service/autocomplete#place_autocomplete_responses
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

        // Put it through options for a clean response
        $options = new OptionsResolver();
        $options->setRequired(['status', 'predictions']);
        $this->data = $options->resolve($data);
    }

    /**
     * Get predictions from query
     * @return PredictionResult[]
     */
    public function getPredictions()
    {
        $rpredictions = [];
        foreach ($this->data['predictions'] as $prediction) {
            $rpredictions[] = new PredictionResult($prediction);
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