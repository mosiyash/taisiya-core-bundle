<?php

namespace Taisiya\CoreBundle\Event;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Taisiya\CoreBundle\Console\Command\Cache\RebuildInternalCacheCommand;
use Taisiya\CoreBundle\Event\Composer\CommandEvent;

class RebuildInternalCacheSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            CommandEvent::NAME => [
                ['rebuildInternalCache', -1000],
            ],
        ];
    }

    /**
     * @param CommandEvent $event
     */
    public function rebuildInternalCache(CommandEvent $event): void
    {
        /** @var ConsoleOutput $output */
        $output = $event->getApp()->getContainer()['console.output'];

        if ($output->isVerbose()) {
            $str = 'Run '.RebuildInternalCacheCommand::NAME.' command';
            $output->writeln('');
            $output->writeln($str);
            $output->writeln(str_repeat('-', strlen($str)));
        }

        $input = new ArrayInput([RebuildInternalCacheCommand::NAME]);
        $event->getApp()->getConsole()->doRun($input, $output);
    }
}
