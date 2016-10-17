<?php

namespace Taisiya\CoreBundle\Event;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
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
                ['rebuildSettings'],
            ],
        ];
    }

    /**
     * @param CommandEvent $event
     */
    public function rebuildSettings(CommandEvent $event): void
    {
        $input  = new ArrayInput([RebuildSettingsCommand::NAME]);
        $output = new ConsoleOutput(OutputInterface::VERBOSITY_VERBOSE);
        $event->getApp()->getConsole()->doRun($input, $output);
    }
}
