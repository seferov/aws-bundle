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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Seferov\AwsBundle\Services\ServicesFactory;
use Seferov\AwsBundle\Services\Helper\ServicesHelper;
use Symfony\Component\HttpKernel\Kernel;

/**
 * SeferovAWSExtension
 */
class SeferovAwsExtension extends Extension
{
    const SERVICE_NAMESPACE = 'seferov_aws';

    /**
     * @var array
     */
    public $configKeys = array('credentials', 'region', 'profile', 'version');

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (Kernel::VERSION < 2.6) {
            $loader->load('service_factory_2.3.xml');
        } else {
            $loader->load('service_factory_3.xml');
        }

        // Base config
        $baseConfig = array();
        foreach ($this->configKeys as $configKey) {
            if ($configKey === 'version') {
                continue 1;
            }
            $baseConfig[$configKey] = array_key_exists($configKey, $config) && $config[$configKey] ? $config[$configKey] : null;
            if(isset($config[$configKey])) {
                $container->setParameter(self::SERVICE_NAMESPACE . '.' . $configKey, $config[$configKey]);
            }
        }

        foreach (ServicesFactory::$AVAILABLE_SERVICES as $service) {
            $serviceKey = ServicesHelper::camelcaseToUnderscore($service);
            if (array_key_exists($serviceKey, $config['services'])) {
                foreach ($this->configKeys as $configKey) {
                    if (!array_key_exists($configKey, $config['services'][$serviceKey]) && array_key_exists($configKey, $baseConfig) && $baseConfig[$configKey]) {
                        $config['services'][$serviceKey][$configKey] = $baseConfig[$configKey];
                    }
                }
            } else {
                $config['services'][$serviceKey] = array_merge($baseConfig, array('version' => 'latest'));
            }
            if(isset($config['services'][$serviceKey])) {
                $container->setParameter(self::SERVICE_NAMESPACE . '.' . $serviceKey, $config['services'][$serviceKey]);
            }
        }
    }
}
