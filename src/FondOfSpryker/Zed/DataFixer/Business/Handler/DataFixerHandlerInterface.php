<?php

namespace FondOfSpryker\Zed\DataFixer\Business\Handler;

interface DataFixerHandlerInterface
{
    /**
     * @param array $fixerNames
     * @param array $stores
     *
     * @return void
     */
    public function fix(array $fixerNames, array $stores): void;

    /**
     * @return array
     */
    public function getAvailableFixer(): array;
}
