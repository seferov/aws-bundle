AWS Bundle
==========

[![Build Status](https://travis-ci.org/seferov/aws-bundle.svg?branch=master)](https://travis-ci.org/seferov/aws-bundle)

Symfony2 AWS Bundle which wraps [official AWS SDK](http://docs.aws.amazon.com/aws-sdk-php/guide/latest/index.html).

## Installation:

### 1. Download

Add to your composer.json

``` js
{
    "require": {
        "seferov/aws-bundle": "~1.0"
    }
}
```

Download the bundle:


``` bash
php composer.phar update seferov/aws-bundle
```

Or simply you can run the command:

``` bash
php composer.phar require seferov/aws-bundle:~1.0
```

### 2. Register

Enable the bundle in the kernel:

``` php
// app/AppKernel.php
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

``` yaml
seferov_aws:
    key: AWS_KEY
    secret: AWS_SECRET
    region: AWS_REGION
    services:
        s3:
            key: AWS_S3_KEY
            secret: AWS_S3_SECRET
            region: AWS_S3_REGION
    # ...
```

For further configuration see [Configuration page](https://github.com/seferov/aws-bundle/blob/master/Resources/doc/configuration.md).

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

For more reference check [offical SDK documentation](http://docs.aws.amazon.com/aws-sdk-php/guide/latest/index.html)