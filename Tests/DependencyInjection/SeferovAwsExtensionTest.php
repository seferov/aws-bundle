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

use PHPUnit\Framework\TestCase;
use Seferov\AwsBundle\DependencyInjection\SeferovAwsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class SeferovAwsExtensionTest.
 */
class SeferovAwsExtensionTest extends TestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private $container;

    /**
     * @var \Seferov\AwsBundle\DependencyInjection\SeferovAwsExtension
     */
    private $extension;

    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new SeferovAwsExtension();
    }

    public function tearDown()
    {
        unset($this->container, $this->extension);
    }

    /**
     * @throws \Exception
     */
    public function testServiceSpecificConfig()
    {
        $this->extension->load(array(
            array(
                'credentials' => array(
                    'key' => 'SOME_KEY',
                    'secret' => 'SOME_SECRET',
                ),
                'services' => array(
                    'sqs' => array(
                        'region' => 'eu-east-1',
                    ),
                    'ses' => array(
                        'credentials' => array(
                            'key' => 'SES_KEY',
                            'secret' => 'SES_SECRET',
                        ),
                    ),
                    'cloud_front' => array(
                        'version' => '2017-10-30',
                    ),
                ),
                'region' => 'eu-west-1',
            ),
        ), $this->container);

        $sqsConfig = $this->extension->getConfig('sqs');
        $this->assertSame('SOME_KEY', $sqsConfig['credentials']['key']);
        $this->assertSame('SOME_SECRET', $sqsConfig['credentials']['secret']);
        $this->assertSame('eu-east-1', $sqsConfig['region']);
        $this->assertSame('latest', $sqsConfig['version']);

        $sesConfig = $this->extension->getConfig('ses');
        $this->assertSame('SES_KEY', $sesConfig['credentials']['key']);
        $this->assertSame('SES_SECRET', $sesConfig['credentials']['secret']);
        $this->assertSame('eu-west-1', $sesConfig['region']);
        $this->assertSame('latest', $sesConfig['version']);

        $sqsConfig = $this->extension->getConfig('cloud_front');
        $this->assertSame('SOME_KEY', $sqsConfig['credentials']['key']);
        $this->assertSame('SOME_SECRET', $sqsConfig['credentials']['secret']);
        $this->assertSame('eu-west-1', $sqsConfig['region']);
        $this->assertSame('2017-10-30', $sqsConfig['version']);

        $sqsConfig = $this->extension->getConfig('elastic_beanstalk');
        $this->assertSame('SOME_KEY', $sqsConfig['credentials']['key']);
        $this->assertSame('SOME_SECRET', $sqsConfig['credentials']['secret']);
        $this->assertSame('eu-west-1', $sqsConfig['region']);
        $this->assertSame('latest', $sqsConfig['version']);
    }
}
