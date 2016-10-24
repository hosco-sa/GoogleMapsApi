<?php
namespace GoogleMapsApi\Places\Object;

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
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getPlaceId()
    {
        return $this->data['place_id'];
    }
}
