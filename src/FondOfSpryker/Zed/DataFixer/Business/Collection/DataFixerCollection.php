<?php

namespace FondOfSpryker\Zed\DataFixer\Business\Collection;

use Countable;
use FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface;
use FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerPluginInterface;
use FondOfSpryker\Zed\DataFixer\Business\Exception\DataFixerNotFoundException;
use FondOfSpryker\Zed\DataFixer\Business\Exception\WrongFixerException;

class DataFixerCollection implements DataFixerCollectionInterface, Countable
{
    /**
     * @var \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface[] $dataFixer
     */
    protected $dataFixer = [];

    /**
     * DataFixerCollection constructor.
     *
     * @param array $dataFixer
     */
    public function __construct(array $dataFixer)
    {
        $this->init($dataFixer);
    }

    /**
     * @param string $name
     *
     * @throws \FondOfSpryker\Zed\DataFixer\Business\Exception\DataFixerNotFoundException
     *
     * @return \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface
     */
    public function getFixer(string $name): DataFixerInterface
    {
        if (!array_key_exists($name, $this->dataFixer)) {
            throw new DataFixerNotFoundException(sprintf(
                'Data fixer with name %s not found. Please be sure to register it in the DataFixerDependencyProvider',
                $name
            ));
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
    public function count()
    {
        return $this->count($this->dataFixer);
    }

    /**
     * @param \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface $dataFixer
     *
     * @return \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerInterface[]
     */
    protected function registerDataFixer(DataFixerInterface $dataFixer): array
    {
        $this->dataFixer[$dataFixer->getName()] = $dataFixer;
        return $this->dataFixer;
    }

    /**
     * @param \FondOfSpryker\Zed\DataFixer\Business\Dependency\DataFixerPluginInterface[] $dataFixer
     *
     * @throws \FondOfSpryker\Zed\DataFixer\Business\Exception\WrongFixerException
     *
     * @return void
     */
    protected function init(array $dataFixer): void
    {
        foreach ($dataFixer as $fixerPlugin) {
            if (!($fixerPlugin instanceof DataFixerPluginInterface)) {
                throw new WrongFixerException(sprintf(
                    'Trying to register wrong fixer. %s is required instead of %s',
                    DataFixerInterface::class,
                    get_class($fixerPlugin)
                ));
            }
            $this->registerDataFixer($fixerPlugin->getDataFixer());
        }
    }
}
