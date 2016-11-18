<?php

/*
 * This file is part of the SeferovAwsBundle package.
 *
 * (c) Farhad Safarov <https://farhadsafarov.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Seferov\AwsBundle\Entity;

use Seferov\AwsBundle\Services\Helper\ServicesHelper;

/**
 * AWS Credentials entity.
 */
class AwsCredentials
{
    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->setParameters($parameters);
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @param null|string $service
     *
     * @return array
     */
    public function getParameters($service = null)
    {
        $serviceKey = ServicesHelper::camelcaseToUnderscore($service);

        return $service
            ? $this->parameters[$serviceKey]
            : array_intersect_key($this->parameters, array_flip(['key', 'secret', 'region']));
    }
}
