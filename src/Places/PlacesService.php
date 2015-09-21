<?php
namespace GoogleMapsApi\Places;

use GoogleMapsApi\Places\Result\PlaceAutocompleteResult;
use GoogleMapsApi\Places\Result\PlaceResult;
use GoogleMapsApi\ServiceApiInterface;
use GuzzleHttp\ClientInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PlacesService
 * @package GoogleMapsApi\Service
 */
class PlacesService implements ServiceApiInterface
{
    const AUTOCOMPLETE_BASE_URL  = 'https://maps.googleapis.com/maps/api/place/autocomplete';
    const PLACE_DETAILS_BASE_URL = 'https://maps.googleapis.com/maps/api/place/details';

    /** @var ClientInterface $httpClient */
    private $client;

    /**
     * @param array ServiceApiInterface
     * @param ClientInterface $httpClient
     */
    public function __construct(array $parameters, ClientInterface $httpClient)
    {
        // Required options for this API
        $options = new OptionsResolver();
        $options->setRequired(['key']);
        $this->options = $options->resolve($parameters);

        // Set HTTP Client
        $this->setHttpClient($httpClient);
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient()
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $httpClient
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->client = $httpClient;
    }

    /**
     * The Place Autocomplete service is a web service that returns place predictions in response to an HTTP request.
     * The request specifies a textual search string and optional geographic bounds. The service can be used to provide
     * autocomplete functionality for text-based geographic searches, by returning places such as businesses, addresses
     * and points of interest as a user types.
     *
     * @param array $parameters
     * @see https://developers.google.com/places/web-service/autocomplete
     * @return PlaceAutocompleteResult
     */
    public function getPlaceAutocomplete(array $parameters)
    {
        // Required and optional parameters for this function call
        $options = new OptionsResolver();
        $options->setRequired(['output', 'input']);
        $options->setDefined(['offset', 'location', 'radius', 'language', 'types', 'components']);
        $options = $options->resolve($parameters);

        // Place the call
        $uri = $this->buildUri(
            sprintf('%s/%s', static::AUTOCOMPLETE_BASE_URL, $options['output']),
            $this->options['key'],
            $parameters
        );

        $request = $this->client->request('GET', $uri);

        return new PlaceAutocompleteResult($request);
    }

    /**
     * Once you have a place_id or a reference from a Place Search, you can request more details about a particular
     * establishment or point of interest by initiating a Place Details request. A Place Details request returns more
     * comprehensive information about the indicated place such as its complete address, phone number, user
     * rating and reviews.
     * @param array $parameters
     * @see https://developers.google.com/places/web-service/details
     * @return PlaceResult
     */
    public function getPlaceDetails(array $parameters)
    {
        // Required and optional parameters for this function call
        $options = new OptionsResolver();
        $options->setRequired(['output', 'placeid']);
        $options->setDefined(['extensions', 'language']);
        $options = $options->resolve($parameters);

        // Place the call
        $uri = $this->buildUri(
            sprintf('%s/%s', static::PLACE_DETAILS_BASE_URL, $options['output']),
            $this->options['key'],
            $parameters
        );

        $request = $this->client->request('GET', $uri);

        return new PlaceResult($request);
    }

    /**
     * @param $uri
     * @param $key
     * @param $parameters
     * @return string
     */
    private function buildUri($uri, $key, $parameters)
    {
        $query = http_build_query($parameters);

        return sprintf('%s?%s&key=%s', $uri, $query, $key);
    }
}