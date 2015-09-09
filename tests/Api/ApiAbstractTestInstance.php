<?php

namespace Artstorm\MonkeyLearn\Tests\Api;

use Artstorm\MonkeyLearn\Api\ApiAbstract;

class ApiAbstractTestInstance extends ApiAbstract
{
    /**
     * @param  string $path
     * @param  array  $parameters
     *
     * @return array
     */
    public function apiPostCall($path, array $parameters = [])
    {
        return parent::post($path, $parameters);
    }
}
