<?php
namespace GoogleMapsApi\Places\Object;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PredictionResult
 * @package GoogleMapsApi\Places\Result
 */
class PlaceObject
{
    /**
     * @var array $data
     */
    private $data;

    /**
     * @param array $data
     * @see https://developers.google.com/places/web-service/autocomplete#place_autocomplete_results
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     * @throws \Symfony\Component\OptionsResolver\Exception\NoSuchOptionException
     * @throws \Symfony\Component\OptionsResolver\Exception\OptionDefinitionException
     * @throws \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     */
    public function __construct(array $data)
    {
        $options = new OptionsResolver();
        $options->setRequired('language');
        $options->setDefined([
            'address_components', 'formatted_address', 'formatted_phone_number', 'geometry', 'icon', 'id',
            'international_phone_number', 'name', 'opening_hours', 'adr_address', 'place_id', 'geometry',
            'reference', 'scope', 'types', 'url', 'vicinity', 'html_attributions', 'photos', 'utc_offset',
            'rating', 'reviews', 'website', 'price_level', 'permanently_closed'
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
     * @return string
     */
    public function getPlaceId()
    {
        return $this->data['place_id'];
    }

    /**
     * @return PlaceAddressObject
     */
    public function getAddressComponents()
    {
        return new PlaceAddressObject($this->data['address_components']);
    }

    /**
     * @return bool
     */
    public function isCity()
    {
        return in_array('locality', $this->data['types'] ?? [], true);
    }

    /**
     * @return bool
     */
    public function isCountry()
    {
        return in_array('country', $this->data['types'] ?? [], true);
    }
}
