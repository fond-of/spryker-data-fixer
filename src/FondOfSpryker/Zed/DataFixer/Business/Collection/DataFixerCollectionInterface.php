<?php

namespace FondOfSpryker\Zed\DataFixer\Business\Collection;

use FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface;
use FondOfSpryker\Zed\DataFixer\Business\Exception\DataFixerNotFoundException;
use FondOfSpryker\Zed\DataFixer\Business\Exception\WrongFixerException;

interface DataFixerCollectionInterface
{
    /**
     * @param  string  $name
     * @return \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface
     * @throws \FondOfSpryker\Zed\DataFixer\Business\Exception\DataFixerNotFoundException
     */
    public function getFixer(string $name): DataFixerInterface;

    /**
     * @return array
     */
    public function getAvailableFixer(): array;

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1
     */
    public function count();
}
