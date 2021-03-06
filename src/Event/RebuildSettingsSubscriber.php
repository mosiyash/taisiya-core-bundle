<?php

namespace Taisiya\CoreBundle\Event;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Input\ArrayInput;
use Taisiya\CoreBundle\Console\Command\Config\RebuildSettingsCommand;
use Taisiya\CoreBundle\Event\Composer\CommandEvent;

class RebuildSettingsSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            CommandEvent::NAME => [
                ['rebuildSettings', -900],
            ],
        ];
    }

    /**
     * @param CommandEvent $event
     */
    public function rebuildSettings(CommandEvent $event): void
    {
        /** @var OutputFormatter $output */
        $output = $event->getApp()->getContainer()['console.output'];

        if ($output->isVerbose()) {
            $str = 'Run '.RebuildSettingsCommand::NAME.' command';
            $output->writeln('');
            $output->writeln($str);
            $output->writeln(str_repeat('-', strlen($str)));
        }

        $input = new ArrayInput([RebuildSettingsCommand::NAME]);
        $event->getApp()->getConsole()->doRun($input, $output);
    }
}
