<?php

namespace FondOfSpryker\Zed\DataFixer\Business;

use FondOfSpryker\Zed\DataFixer\Business\Collection\DataFixerCollection;
use FondOfSpryker\Zed\DataFixer\Business\Collection\DataFixerCollectionInterface;
use FondOfSpryker\Zed\DataFixer\Business\Handler\DataFixerHandler;
use FondOfSpryker\Zed\DataFixer\Business\Handler\DataFixerHandlerInterface;
use FondOfSpryker\Zed\DataFixer\DataFixerDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

/**
 * @method \FondOfSpryker\Zed\DataFixer\DataFixerConfig getConfig()
 */
class DataFixerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\DataFixer\Business\DataFixerHandlerInterface
     */
    public function createDataFixerHandler(): DataFixerHandlerInterface
    {
        return new DataFixerHandler($this->createDataFixerCollection(), $this->getStoreFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\DataFixer\Business\Collection\DataFixerCollectionInterface
     */
    protected function createDataFixerCollection(): DataFixerCollectionInterface
    {
        return new DataFixerCollection($this->getRegisteredDataFixer());
    }

    /**
     * @return \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface[]
     */
    protected function getRegisteredDataFixer(): array
    {
        return $this->getProvidedDependency(DataFixerDependencyProvider::REGISTERED_DATA_FIXER);
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(DataFixerDependencyProvider::FACADE_STORE);
    }
}
