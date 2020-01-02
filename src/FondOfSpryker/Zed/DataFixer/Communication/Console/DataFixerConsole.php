<?php

namespace FondOfSpryker\Zed\DataFixer\Communication\Console;

use Exception;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DataFixerConsole extends Console
{
    public const COMMAND_NAME = 'data-fixer:fix';
    public const DESCRIPTION = '';
    public const RESOURCE_FIXER = 'fixer';
    public const RESOURCE_FIXER_SHORTCUT = 'f';
    public const STORE_IDS = 'store_ids';
    public const STORE_IDS_SHORTCUT = 's';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->addOption(
            static::RESOURCE_FIXER,
            static::RESOURCE_FIXER_SHORTCUT,
            InputArgument::OPTIONAL,
            sprintf(
                'Defines the fixer to use. Available fixer: %s-> %s',
                PHP_EOL,
                implode(PHP_EOL . '-> ', $this->getFacade()->getRegisteredFixerNames())
            )
        );
        $this->addOption(
            static::STORE_IDS,
            static::STORE_IDS_SHORTCUT,
            InputArgument::OPTIONAL,
            'Run command only for given store ids'
        );
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION)
            ->addUsage(sprintf('-%s fixer -%s store_ids', static::RESOURCE_FIXER_SHORTCUT, static::STORE_IDS_SHORTCUT));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $status = static::CODE_SUCCESS;
        $messenger = $this->getMessenger();
        $files = [];

        $fixerNames = [];
        if ($input->getOption(static::RESOURCE_FIXER)) {
            $resourceString = $input->getOption(static::RESOURCE_FIXER);
            $fixerNames = explode(',', $resourceString);
        }

        $stores = [];
        if ($input->getOption(static::STORE_IDS)) {
            $storeIdsString = $input->getOption(static::STORE_IDS);
            $stores = explode(',', $storeIdsString);
        }

        if (count($stores) === 0) {
            $stores = [Store::getInstance()->getStoreName()];
        }

        try {
            $this->getFacade()->handleFixer($fixerNames, $stores);
        } catch (Exception $exception) {
            $status = static::CODE_ERROR;
            $messenger->error(sprintf(
                'Command %s failt with message: %s%s!',
                static::COMMAND_NAME,
                PHP_EOL,
                $exception->getMessage()
            ));
        }
        $messenger->info(sprintf(
            'You just executed %s!',
            static::COMMAND_NAME
        ));
        return $status;
    }
}
