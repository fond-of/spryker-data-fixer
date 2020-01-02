<?php

namespace FondOfSpryker\Zed\DataFixer\Business;

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

    /**
     * @param array $fixerNames
     * @param array $stores
     *
     * @return void
     */
    public function handleFixer(array $fixerNames, array $stores): void
    {
        $this->getFactory()->createDataFixerHandler()->fix($fixerNames, $stores);
    }
}
