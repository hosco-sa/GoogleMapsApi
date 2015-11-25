<?php
namespace GoogleMapsApi\Geocode\Object;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GeocodeAddressObject
 * @see https://developers.google.com/places/supported_types
 * @package GoogleMapsApi\Geocode\Object
 */
class GeocodeAddressObject
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $this->resolveAddress($data);
    }

    /**
     * @param array $data
     * @return array
     * @see https://developers.google.com/maps/documentation/geocoding/intro#Types
     */
    private function resolveAddress(array $data)
    {
        // Set possible options
        $options = new OptionsResolver();
        $options->setDefaults([
            'locality' => '',
            'sublocality' => '',
            'sublocality_level_1' => '',
            'sublocality_level_2' => '',
            'sublocality_level_3' => '',
            'sublocality_level_4' => '',
            'sublocality_level_5' => '',
            'postal_code' => '',
            'postal_code_prefix' => '',
            'postal_town' => '',
            'neighborhood' => '',
            'premise' => '',
            'subpremise' => '',
            'natural_feature' => '',
            'airport' => '',
            'park' => '',
            'point_of_interest' => '',
            'ward' => '',
            'street_address' => '',
            'route' => '',
            'intersection' => '',
            'political' => '',
            'country' => '',
            'administrative_area_level_1' => '',
            'administrative_area_level_2' => '',
            'administrative_area_level_3' => '',
            'administrative_area_level_4' => '',
            'administrative_area_level_5' => '',
            'colloquial_area' => '',
            'street_number' => ''
        ]);

        // Process Google API Result format
        $rdata = [];
        foreach ($data as $component) {
            // The first element of the types array is the type of the component
            $type = current($component['types']);

            // Register data
            $rdata[$type] = $component;
        }

        return $options->resolve($rdata);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param bool|true $short
     * @return string
     */
    public function getLocality($short = true)
    {
        return $this->data['locality'] ? $this->data['locality'][$short ? 'short_name' : 'long_name'] : '';
    }

    /**
     * @param bool|true $short
     * @return string
     */
    public function getSubLocality($short = true)
    {
        return $this->data['sublocality'] ? $this->data['sublocality'][$short ? 'short_name' : 'long_name'] : '';
    }

    /**
     * @param bool|true $short
     * @return string
     */
    public function getPostalCode($short = true)
    {
        return $this->data['postal_code'] ? $this->data['postal_code'][$short ? 'short_name' : 'long_name'] : '';
    }

    /**
     * @param bool|true $short
     * @return string
     */
    public function getCountry($short = true)
    {
        return $this->data['country'] ? $this->data['country'][$short ? 'short_name' : 'long_name'] : '';
    }

    /**
     * @param bool|true $short
     * @return string
     */
    public function getAdminLevel1($short = true)
    {
        return $this->data['administrative_area_level_1'] ? $this->data['administrative_area_level_1'][$short ? 'short_name' : 'long_name'] : '';
    }

    /**
     * @param bool|true $short
     * @return string
     */
    public function getAdminLevel2($short = true)
    {
        return $this->data['administrative_area_level_2'] ? $this->data['administrative_area_level_2'][$short ? 'short_name' : 'long_name'] : '';
    }

    /**
     * @param bool|true $short
     * @return string
     */
    public function getAdminLevel3($short = true)
    {
        return $this->data['administrative_area_level_3'] ? $this->data['administrative_area_level_3'][$short ? 'short_name' : 'long_name'] : '';
    }

    /**
     * @param bool|true $short
     * @return string
     */
    public function getLowestAdminLevel($short = true)
    {
        return $this->getAdminLevel3($short) ?: $this->getAdminLevel2($short) ?: $this->getAdminLevel1($short);
    }

    /**
     * @param bool|true $short
     * @return string
     */
    public function getHighestAdminLevel($short = true)
    {
        return $this->getAdminLevel1($short) ?: $this->getAdminLevel2($short) ?: $this->getAdminLevel3($short);
    }
}