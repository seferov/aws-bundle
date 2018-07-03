<?php

/*
 * This file is part of the SeferovAwsBundle package.
 *
 * (c) Farhad Safarov <https://farhadsafarov.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Seferov\AwsBundle\Util;

use PHPUnit\Framework\TestCase;

class StringUtilTest extends TestCase
{
    /**
     * @dataProvider camelcaseToUnderscoreData
     *
     * @param $input
     * @param $result
     */
    public function testCamelcaseToUnderscore($input, $result)
    {
        $this->assertSame($result, StringUtil::camelcaseToUnderscore($input));
    }

    public function camelcaseToUnderscoreData()
    {
        return array(
            array('cloudFront', 'cloud_front'),
            array('elasticBeanstalk', 'elastic_beanstalk'),
            array('elasticLoadBalancing', 'elastic_load_balancing'),
            array('acmpca', 'acmpca'),
        );
    }
}
