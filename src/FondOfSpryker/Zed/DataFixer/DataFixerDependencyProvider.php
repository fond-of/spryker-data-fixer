<?php

namespace FondOfSpryker\Zed\DataFixer;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class DataFixerDependencyProvider extends AbstractBundleDependencyProvider
{
    public const REGISTERED_DATA_FIXER = 'REGISTERED_DATA_FIXER';
    public const FACADE_STORE = 'FACADE_STORE';
    public const FACADE_PRODUCT = 'FACADE_PRODUCT';
    public const FACADE_AVAILABILITY_STORAGE = 'FACADE_AVAILABILITY_STORAGE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->registerDataFixer($container);
        $container = $this->addStoreFacade($container);
        $container = $this->addProductFacade($container);
        $container = $this->addAvailabilityStorageFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array
     */
    public function getDataFixer(Container $container): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function registerDataFixer(Container $container): Container
    {
        $container[static::REGISTERED_DATA_FIXER] = function (Container $container) {
            return $this->getDataFixer($container);
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = function (Container $container) {
            return $container->getLocator()->store()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductFacade(Container $container): Container
    {
        $container[static::FACADE_PRODUCT] = function (Container $container) {
            return $container->getLocator()->product()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAvailabilityStorageFacade(Container $container): Container
    {
        $container[static::FACADE_AVAILABILITY_STORAGE] = function (Container $container) {
            return $container->getLocator()->availabilityStorage()->facade();
        };

        return $container;
    }
}
