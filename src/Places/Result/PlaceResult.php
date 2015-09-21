<?php
namespace GoogleMapsApi\Places\Result;

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
     * @param array $data
     * @see https://developers.google.com/places/web-service/details#PlaceDetailsResults
     */
    public function __construct(array $data)
    {
        $options = new OptionsResolver();
        $options->setRequired(['address_components']);
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