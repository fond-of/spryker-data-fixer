<?php

namespace FondOfSpryker\Zed\DataFixer\Business;

interface DataFixerFacadeInterface
{
    /**
     * @return array
     */
    public function getRegisteredFixerNames(): array;

    /**
     * @param array $fixerNames
     * @param array $stores
     *
     * @return void
     */
    public function handleFixer(array $fixerNames, array $stores): void;
}
