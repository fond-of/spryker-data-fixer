<?php

namespace FondOfSpryker\Zed\DataFixer\Business\Collection;

use FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface;
use FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerPluginInterface;
use FondOfSpryker\Zed\DataFixer\Business\Exception\DataFixerNotFoundException;
use FondOfSpryker\Zed\DataFixer\Business\Exception\WrongFixerException;

class DataFixerCollection implements DataFixerCollectionInterface, \Countable
{
    /**
     * @var DataFixerInterface[] $dataFixer
     */
    protected $dataFixer = [];

    /**
     * DataFixerCollection constructor.
     * @param  array  $dataFixer
     * @throws \FondOfSpryker\Zed\DataFixer\Business\Exception\WrongFixerException
     */
    public function __construct(array $dataFixer)
    {
        $this->init($dataFixer);
    }

    /**
     * @param  string  $name
     * @return \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface
     * @throws \FondOfSpryker\Zed\DataFixer\Business\Exception\DataFixerNotFoundException
     */
    public function getFixer(string $name): DataFixerInterface
    {
        if (!array_key_exists($name, $this->dataFixer)) {
            throw new DataFixerNotFoundException(sprintf('Data fixer with name %s not found. Please be sure to register it in the DataFixerDependencyProvider',
                $name));
        }

        return $this->dataFixer[$name];
    }

    /**
     * @return array
     */
    public function getAvailableFixer(): array
    {
        return array_keys($this->dataFixer);
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1
     */
    public function count()
    {
        return $this->count($this->dataFixer);
    }

    /**
     * @param  \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface  $dataFixer
     * @return array|DataFixerInterface[]
     */
    protected function registerDataFixer(DataFixerInterface $dataFixer): array
    {
        $this->dataFixer[$dataFixer->getName()] = $dataFixer;
        return $this->dataFixer;
    }

    /**
     * @param  array|\FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerPluginInterface[]  $dataFixer
     * @return void
     * @throws \FondOfSpryker\Zed\DataFixer\Business\Exception\WrongFixerException
     */
    protected function init(array $dataFixer): void
    {
        foreach ($dataFixer as $fixerPlugin) {
            if (!($fixerPlugin instanceof DataFixerPluginInterface)) {
                throw new WrongFixerException(sprintf('Trying to register wrong fixer. %s is required instead of %s',
                    DataFixerInterface::class, get_class($fixerPlugin)));
            }
            $this->registerDataFixer($fixerPlugin->getDataFixer());
        }
    }


}
