<?php

namespace FondOfSpryker\Zed\DataFixer\Business\Dependency;

interface DataFixerInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param array $stores
     *
     * @return bool
     */
    public function fix(array $stores): bool;
}
