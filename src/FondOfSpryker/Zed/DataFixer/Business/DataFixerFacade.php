<?php

namespace FondOfSpryker\Zed\DataFixer\Business;

use FondOfSpryker\Zed\DataFixer\DataFixerDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\DataFixer\Business\DataFixerBusinessFactory getFactory()
 */
class DataFixerFacade extends AbstractFacade implements DataFixerFacadeInterface
{
    /**
     * @return array
     */
    public function getRegisteredFixerNames(): array
    {
        return $this->getFactory()->createDataFixerHandler()->getAvailableFixer();
    }

    public function handleFixer(array $fixerNames, array $stores)
    {
        $this->getFactory()->createDataFixerHandler()->fix($fixerNames, $stores);
    }
}
