<?php

namespace Taisiya\CoreBundle\Composer;

use Composer\Composer;
use Composer\EventDispatcher\Event;
use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Taisiya\CoreBundle\App;
use Taisiya\CoreBundle\Event\Composer\CommandEvent;
use Taisiya\CoreBundle\Event\Composer\InstallerEvent;
use Taisiya\CoreBundle\Event\Composer\PackageEvent;
use Taisiya\CoreBundle\Event\Composer\PluginEvent;

class ScriptHandler
{
    /**
     * @param Composer $composer
     *
     * @return string
     */
    final protected static function getRootDir(Composer $composer): string
    {
        if (!defined('TAISIYA_ROOT')) {
            define('TAISIYA_ROOT', dirname($composer->getConfig()->get('vendor-dir')));
        }

        return TAISIYA_ROOT;
    }

    /**
     * @param Event $event
     */
    final public static function runEvents(Event $event): void
    {
        $rootDir = self::getRootDir($event->getComposer());

        $app = file_exists($rootDir.'/bootstrap.php')
            ? require_once $rootDir.'/bootstrap.php' :
            new App(['settings' => require_once $rootDir.'/app/config/settings.php']);

        /** @var EventDispatcher $dispatcher */
        $dispatcher = $app->getContainer()['event_dispatcher'];

        foreach (require_once $rootDir.'/var/cache/internal/events_subscribers.cache.php' as $subscriberClass) {
            $dispatcher->addSubscriber(new $subscriberClass());
        }

        if (preg_match('/-cmd$/', $event->getName())) {
            $detailedEventClass = 'Taisiya\\CoreBundle\\Event\\Composer\\CommandEvent\\'.Inflector::classify($event->getName()).'Event';
        } elseif (preg_match('/-dependencies-solving$/', $event->getName())) {
            $detailedEventClass = 'Taisiya\\CoreBundle\\Event\\Composer\\InstallerEvent\\'.Inflector::classify($event->getName()).'Event';
        } elseif (preg_match('/-package-/', $event->getName())) {
            $detailedEventClass = 'Taisiya\\CoreBundle\\Event\\Composer\\PackageEvent\\'.Inflector::classify($event->getName()).'Event';
        } elseif (preg_match('/^(init|command|pre-file-download)$/', $event->getName())) {
            $detailedEventClass = 'Taisiya\\CoreBundle\\Event\\Composer\\PluginEvent\\'.Inflector::classify($event->getName()).'Event';
        }
        $detailedEvent = new $detailedEventClass($app);
        $dispatcher->dispatch($detailedEvent::NAME, $detailedEvent);

        if (preg_match('/-cmd$/', $event->getName())) {
            $commandEvent = new CommandEvent($app);
            $dispatcher->dispatch($commandEvent::NAME, $commandEvent);
        } elseif (preg_match('/-dependencies-solving$/', $event->getName())) {
            $installerEvent = new InstallerEvent($app);
            $dispatcher->dispatch($installerEvent::NAME, $installerEvent);
        } elseif (preg_match('/-package-/', $event->getName())) {
            $packageEvent = new PackageEvent($app);
            $dispatcher->dispatch($packageEvent::NAME, $packageEvent);
        } elseif (preg_match('/^(init|command|pre-file-download)$/', $event->getName())) {
            $pluginEvent = new PluginEvent($app);
            $dispatcher->dispatch($pluginEvent::NAME, $pluginEvent);
        }
    }
}
