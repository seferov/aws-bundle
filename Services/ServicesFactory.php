<?php
/*
 * This file is part of the SeferovAwsBundle package.
 *
 * (c) Farhad Safarov <https://farhadsafarov.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Seferov\AwsBundle\Services;

use Aws\Sdk as Aws;
use Seferov\AwsBundle\Entity\AWSCredentials;

/**
 * Factory class that initiates an AWS client
 */
class ServicesFactory
{
    /**
     * @var array
     */
    public static $AVAILABLE_SERVICES = [
        'CloudFront',
        'CloudSearch',
        'CloudWatch',
        'CloudWatchLogs',
        'CognitoIdentity',
        'CognitoSync',
        'DynamoDb',
        'Ec2',
        'Emr',
        'ElasticTranscoder',
        'ElastiCache',
        'Glacier',
        'Redshift',
        'Rds',
        'Route53',
        'Ses',
        'Sns',
        'Sqs',
        'S3',
        'Swf',
        'AutoScaling',
        'CloudFormation',
        'CloudTrail',
        'DataPipeline',
        'DirectConnect',
        'ElasticBeanstalk',
        'Iam',
        'ImportExport',
        'OpsWorks',
        'Sts',
        'StorageGateway',
        'Support',
        'ElasticLoadBalancing'
    ];

    /**
     * @param AWSCredentials $AWSCredentials
     * @param $service
     *
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function get(AWSCredentials $AWSCredentials, $service)
    {
        $aws = new Aws($AWSCredentials->getParameters());
        return $aws->createClient($service, $AWSCredentials->getParameters($service));
    }
}
