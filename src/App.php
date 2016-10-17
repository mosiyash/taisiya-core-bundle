<?php

namespace Taisiya\CoreBundle;

use JBZoo\PimpleDumper\PimpleDumper;
use Pimple\Container;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Taisiya\CoreBundle\Exception\RuntimeException;

final class App extends \Slim\App
{
    /**
     * @var Console
     */
    private $console;

    /**
     * {@inheritdoc}
     */
    public function __construct($container = [])
    {
        parent::__construct($container);

        $this->getContainer()['event_dispatcher'] = function (Container $pimple) {
            return new EventDispatcher();
        };

        $this->getContainer()['console.output'] = function (Container $pimple) {
            return new ConsoleOutput(OutputInterface::VERBOSITY_VERBOSE);
        };

        if (class_exists(PimpleDumper::class)) {
            $this->getContainer()->register(new PimpleDumper());
        }
    }

    /**
     * @return Console
     */
    public function getConsole(): Console
    {
        return $this->console;
    }

    /**
     * @param Console $console
     *
     * @throws RuntimeException
     */
    public function setConsole(Console $console): void
    {
        if ($this->console) {
            throw new RuntimeException('Console already sets');
        }

        $this->console = $console;
    }
}
