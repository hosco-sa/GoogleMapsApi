<?php
namespace GoogleMapsApi\Geocode\Object;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PredictionResult
 * @package GoogleMapsApi\Places\Result
 */
class GeocodeObject
{
    /**
     * @var array $data
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $options = new OptionsResolver();
        $options->setRequired('language');
        $options->setDefined([
            'address_components', 'formatted_address', 'formatted_phone_number', 'geometry', 'icon', 'id',
            'international_phone_number', 'name', 'opening_hours', 'adr_address', 'place_id', 'geometry',
            'reference', 'scope', 'types', 'url', 'vicinity', 'html_attributions'
        ]);
        $this->data = $options->resolve($data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->data['language'];
    }

    /**
     * @return PlaceAddressObject
     */
    public function getAddressComponents()
    {
        return new GeocodeAddressObject($this->data['address_components']);
    }

    /**
     * @return bool
     */
    public function isCity()
    {
        return in_array('locality', $this->data['types']);
    }

    /**
     * @return bool
     */
    public function isCountry()
    {
        return in_array('country', $this->data['types']);
    }
}