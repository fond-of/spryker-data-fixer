<?php

namespace FondOfSpryker\Zed\DataFixer\Business\Dependency;

use FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface;

interface DataFixerPluginInterface
{

    /**
     * @return \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface
     */
    public function getDataFixer(): DataFixerInterface;

}
