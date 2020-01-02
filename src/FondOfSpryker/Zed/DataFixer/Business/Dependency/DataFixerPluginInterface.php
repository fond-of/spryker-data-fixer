<?php

namespace FondOfSpryker\Zed\DataFixer\Business\Dependency;

interface DataFixerPluginInterface
{
    /**
     * @return \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface
     */
    public function getDataFixer(): DataFixerInterface;
}
