<?php
namespace GoogleMapsApi\Places\Object;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PredictionResult
 * @package GoogleMapsApi\Places\Result
 */
class PredictionObject
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
        $options = new OptionsResolver();
        $options->setRequired(['description', 'place_id', 'reference', 'id', 'terms', 'types', 'matched_substrings']);
        $this->data = $options->resolve($data);
    }

    /**
     * @return string
     */
    public function getPlaceId()
    {
        return $this->data['place_id'];
    }
}