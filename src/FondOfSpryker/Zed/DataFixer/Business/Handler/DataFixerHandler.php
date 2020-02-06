<?php

namespace FondOfSpryker\Zed\DataFixer\Business\Handler;

use FondOfSpryker\Zed\DataFixer\Business\Collection\DataFixerCollectionInterface;
use FondOfSpryker\Zed\DataFixer\Business\Exception\StoreNotFoundException;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class DataFixerHandler implements DataFixerHandlerInterface
{
    /**
     * @var \FondOfSpryker\Zed\DataFixer\Business\Collection\DataFixerCollectionInterface
     */
    protected $dataFixer;

    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @param \FondOfSpryker\Zed\DataFixer\Business\Collection\DataFixerCollectionInterface $dataFixer
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     */
    public function __construct(DataFixerCollectionInterface $dataFixer, StoreFacadeInterface $storeFacade)
    {
        $this->dataFixer = $dataFixer;
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param array $fixerNames
     * @param array $stores
     *
     * @return void
     */
    public function fix(array $fixerNames, array $stores): void
    {
        $stores = $this->prepareAndValidateStores($stores);
        foreach ($fixerNames as $fixerName) {
            $this->dataFixer->getFixer($fixerName)->fix($stores);
        }
    }

    /**
     * @return array
     */
    public function getAvailableFixer(): array
    {
        return $this->dataFixer->getAvailableFixer();
    }

    /**
     * @param array $stores
     *
     * @throws \FondOfSpryker\Zed\DataFixer\Business\Exception\StoreNotFoundException
     *
     * @return array
     */
    protected function prepareAndValidateStores(array $stores): array
    {
        $ids = [];
        $allStores = $this->storeFacade->getAllStores();
        foreach ($stores as $store) {
            foreach ($allStores as $storeTransfer) {
                if ($storeTransfer->getName() === $store || (is_numeric($store) && $storeTransfer->getIdStore() === (int)$store)) {
                    $ids[$storeTransfer->getName()] = $storeTransfer->getIdStore();
                    break;
                }
            }
        }

        if (count($ids) !== count($stores)) {
            throw new StoreNotFoundException(sprintf(
                'Could not match all stores %s => %s',
                json_encode($stores),
                json_encode($ids)
            ));
        }

        return $ids;
    }
}
