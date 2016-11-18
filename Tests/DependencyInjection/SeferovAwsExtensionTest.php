<?php
/*
 * This file is part of the SeferovAwsBundle package.
 *
 * (c) Farhad Safarov <https://farhadsafarov.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Seferov\AwsBundle\Tests\DependencyInjection;

use Seferov\AwsBundle\DependencyInjection\SeferovAwsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class SeferovAwsExtensionTest.
 */
class SeferovAwsExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private $container;

    /**
     * @var \Seferov\AwsBundle\DependencyInjection\SeferovAwsExtension
     */
    private $extension;

    /**
     * @var array
     */
    private static $config = [
        [
            'credentials' => [
                'key'    => 'SOME_KEY',
                'secret' => 'SOME_SECRET',
            ],
            'services' => [
                'sqs' => [
                    'region' => 'eu-west-1',
                ],
            ],
        ],
    ];

    /**
     * @var array
     */
    private static $services = ['s3', 'sqs'];

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new SeferovAwsExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->container, $this->extension);
    }

    public function testServices()
    {
        $this->extension->load(self::$config, $this->container);

        foreach (self::$services as $service) {
            $this->assertTrue($this->container->hasDefinition('aws.'.$service));
        }
    }
}
