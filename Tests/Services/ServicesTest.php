<?php

/*
 * This file is part of the SeferovAwsBundle package.
 *
 * (c) Farhad Safarov <https://farhadsafarov.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Seferov\AwsBundle\Tests\Services;

use Seferov\AwsBundle\Services\ServicesFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests for various services.
 */
class ServicesTest extends WebTestCase
{
    public function testAvailableServices()
    {
        $client = static::createClient();
        $availableServices = ServicesFactory::$AVAILABLE_SERVICES;

        foreach ($availableServices as $service) {
            $this->assertEquals('Aws\\'.$service.'\\'.$service.'Client', get_class($client->getContainer()->get('aws.'.strtolower($service))));
        }
    }

    /**
     * @expectedException \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function testNonExistentService()
    {
        $client = static::createClient();

        $client->getContainer()->get('aws.nonexistentservice');
    }
}
