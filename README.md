AWS Bundle
==========

[![Build Status](https://travis-ci.org/seferov/awsBundle.svg?branch=master)](https://travis-ci.org/seferov/awsBundle)
[![Test Coverage](https://codeclimate.com/github/seferov/awsBundle/badges/coverage.svg)](https://codeclimate.com/github/seferov/awsBundle/coverage)
[![Code Climate](https://codeclimate.com/github/seferov/awsBundle/badges/gpa.svg)](https://codeclimate.com/github/seferov/awsBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5110d57d-0c10-48b5-a43f-df476ba0ad28/mini.png)](https://insight.sensiolabs.com/projects/5110d57d-0c10-48b5-a43f-df476ba0ad28)

Amazon Web Services Symfony Bundle built on the top of [official AWS SDK](http://docs.aws.amazon.com/aws-sdk-php/guide/latest/index.html).

Available services: CloudFront, CloudSearch, CloudWatch, CloudWatchLogs, CognitoIdentity, CognitoSync, DynamoDB, EC2, EMR, Elastic Transcoder, ElastiCache, Glacier, Redshift, RDS, Route 53, SES, SNS, SQS, S3, SWF, SimpleDB, AutoScaling, CloudFormation, CloudTrail, DataPipeline, DirectConnect, ElasticBeanstalk, IAM, ImportExport, OpsWorks, STS, StorageGateway, Support, ElasticLoadBalancing

## Installation:

### 1. Download

Download the bundle:

``` bash
composer require seferov/aws-bundle
```

### 2. Register

Enable the bundle in `app/AppKernel.php`:

``` php
// ...
public function registerBundles()
{
    $bundles = array(
        // ...
        new Seferov\AwsBundle\SeferovAwsBundle(),
    );
}
```

### 3. Configure

Add the following configuration to your `app/config/config.yml`

Example:

``` yaml
seferov_aws:
    credentials:
        key: AWS_KEY
        secret: AWS_SECRET
    region: AWS_REGION
    services:
        s3:
            credentials:
                key: AWS_S3_KEY
                secret: AWS_S3_SECRET
            region: AWS_S3_REGION
            version: '2006-03-01'
            endpoint: 'http://192.168.99.100:9324'	// Optional for local debug with service mocks
    # ...
```

Service names are underscored, such as `elastic_beanstalk`.

For further configuration see [Configuration page]("https://github.com/seferov/aws-bundle/blob/master/Resources/doc/configuration.md").

## Usage

Example:

``` php
// AWS S3 example
public function someAction()
{
    $client = $this->get('aws.s3');

    // Upload an object to Amazon S3
    $result = $client->putObject(array(
        'Bucket' => $bucket,
        'Key'    => 'data.txt',
        'Body'   => 'Hello!'
    ));
    // ...
}
```

For more reference check [official SDK documentation]("http://docs.aws.amazon.com/aws-sdk-php/guide/latest/index.html")
