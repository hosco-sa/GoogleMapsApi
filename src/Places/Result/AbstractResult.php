<?php
namespace GoogleMapsApi\Places\Result;

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
     * @param $object
     * @return bool
     */
    public function checkRequestStatus($object)
    {
        if (!in_array($object->getStatus(), [REQUEST_ZERO_RESULTS, REQUEST_OK])) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    abstract public function getStatus();
}