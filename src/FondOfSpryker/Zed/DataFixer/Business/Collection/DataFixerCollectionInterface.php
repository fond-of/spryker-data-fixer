<?php

namespace FondOfSpryker\Zed\DataFixer\Business\Collection;

use FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface;

interface DataFixerCollectionInterface
{
    /**
     * @param string $name
     *
     * @throws \FondOfSpryker\Zed\DataFixer\Business\Exception\DataFixerNotFoundException
     *
     * @return \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface
     */
    public function getFixer(string $name): DataFixerInterface;

    /**
     * @return array
     */
    public function getAvailableFixer(): array;

    /**
     * Count elements of an object
     *
     * @link https://php.net/manual/en/countable.count.php
     *
     * @since 5.1
     *
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count();
}
