<?php
namespace GoogleMapsApi\Service;

use GuzzleHttp\ClientInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlacesService implements ServiceApiInterface
{
    const AUTOCOMPLETE_BASE_URL = 'https://maps.googleapis.com/maps/api/place/autocomplete';

    /** @var ClientInterface $httpClient */
    private $client;

    public function __construct(array $options, ClientInterface $httpClient)
    {
        // Required options for this API
        $options = new OptionsResolver();
        $options->setRequired(['key']);
        $this->options = $options->resolve($options);

        // Set HTTP Client
        $this->setHttpClient($httpClient);
    }

    public function getHttpClient()
    {
        return $this->client;
    }

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
     */
    public function getPlaceAutocomplete(array $parameters)
    {
        // Required and optional parameters for this function call
        $options = new OptionsResolver();
        $options->setRequired(['output', 'input']);
        $options->setDefined(['offset', 'location', 'radius', 'language', 'types', 'components']);
        $options->resolve($parameters);

        // Place the call
        $uri = $this->buildUri(
            sprintf('%s/%s', static::AUTOCOMPLETE_BASE_URL, $options['output']),
            $parameters
        );

        $this->client->request('GET', $uri);
    }

    private function buildUri($uri, $parameters)
    {
        $query = http_build_query($parameters);

        return http_build_url($uri, ['query' => $query]);
    }
}