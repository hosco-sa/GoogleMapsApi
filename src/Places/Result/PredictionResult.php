<?php
namespace GoogleMapsApi\Places\Result;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PredictionResult
 * @package GoogleMapsApi\Places\Result
 */
class PredictionResult
{
    /**
     * @var array $data
     */
    private $data;

    /**
     * @param array $data
     * @see https://developers.google.com/places/web-service/autocomplete#place_autocomplete_results
     */
    public function __construct(array $data)
    {
        $data = new OptionsResolver();
        $data->setRequired(['description', 'place_id', 'reference', 'id', 'terms', 'types', 'matched_substring']);
        $this->data = $data->resolve($data);
    }

    /**
     * @return string
     */
    public function getPlaceId()
    {
        return $this->data['place_id'];
    }
}