<?php
namespace GoogleMapsApi\Geocode\Result;

/**
 * Class AbstractResult
 * @package GoogleMapsApi\Result
 */
abstract class AbstractResult
{
    const REQUEST_ZERO_RESULTS = 'ZERO_RESULTS';

    const REQUEST_OK = 'OK';

    /**
     * Check Google API response
     * @return bool
     */
    public function checkRequestStatus()
    {
        if (!in_array($this->getStatus(), [static::REQUEST_ZERO_RESULTS, static::REQUEST_OK])) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    abstract public function getStatus();
}