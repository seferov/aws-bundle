<?php

/*
 * This file is part of the SeferovAwsBundle package.
 *
 * (c) Farhad Safarov <https://farhadsafarov.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Seferov\AwsBundle\DependencyInjection;

use Seferov\AwsBundle\Util\StringUtil;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Seferov\AwsBundle\Services\ServicesFactory;

/**
 * SeferovAWSExtension.
 */
class SeferovAwsExtension extends Extension
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->config = $this->processConfiguration($configuration, $configs);

        foreach (ServicesFactory::getAvailableServices() as $service) {
            $serviceKey = StringUtil::camelcaseToUnderscore($service);
            $definition = new Definition('Aws\\'.$service.'\\'.$service.'Client', array($this->getConfig($serviceKey)));
            $definition->setPublic(true);
            $container->setDefinition('aws.'.$serviceKey, $definition);
        }
    }

    /**
     * @param $service
     *
     * @return array
     */
    public function getConfig($service)
    {
        $baseConfig = array(
            'credentials' => $this->config['credentials'],
            'region' => $this->config['region'],
            'profile' => $this->config['profile'],
            'version' => 'latest',
        );

        if (!isset($this->config['services'][$service])) {
            return $baseConfig;
        }

        return array_merge($baseConfig, $this->config['services'][$service]);
    }
}
