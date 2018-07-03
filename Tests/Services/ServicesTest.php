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
use Seferov\AwsBundle\Tests\app\Kernel;
use Seferov\AwsBundle\Util\StringUtil;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Tests for various services.
 */
class ServicesTest extends KernelTestCase
{
    public function testAvailableServices()
    {
        static::bootKernel();
        $availableServices = ServicesFactory::getAvailableServices();

        foreach ($availableServices as $service) {
            $this->assertSame(
                'Aws\\'.$service.'\\'.$service.'Client',
                get_class(static::$kernel->getContainer()->get('aws.'.strtolower(StringUtil::camelcaseToUnderscore($service))))
            );
        }
    }

    /**
     * @expectedException \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function testNonExistentService()
    {
        static::bootKernel();

        static::$kernel->getContainer()->get('aws.nonexistentservice');
    }

    public static function getKernelClass()
    {
        return Kernel::class;
    }
}
