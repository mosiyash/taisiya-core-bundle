<?php

namespace Taisiya\CoreBundle\Composer;

use Composer\EventDispatcher\Event;
use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Taisiya\CoreBundle\App;
use Taisiya\CoreBundle\Event\Composer\CommandEvent;
use Taisiya\CoreBundle\Event\Composer\InstallerEvent;
use Taisiya\CoreBundle\Event\Composer\PackageEvent;
use Taisiya\CoreBundle\Event\Composer\PluginEvent;

defined('TAISIYA_ROOT') || define('TAISIYA_ROOT', dirname(dirname(__DIR__)));

class ScriptHandler
{
    const EVENT_EXECUTE = 'composer.handler.execute';

    /**
     * @param Event $event
     */
    final public static function runCommandEvents(Event $event): void
    {
        $app = file_exists(TAISIYA_ROOT.'/bootstrap.php')
            ? require_once TAISIYA_ROOT.'/bootstrap.php' :
            new App(['settings' => require_once TAISIYA_ROOT.'/app/config/settings.php']);

        /** @var EventDispatcher $dispatcher */
        $dispatcher = $app->getContainer()['event_dispatcher'];

        foreach (require_once TAISIYA_ROOT.'/var/cache/internal/events_subscribers.cache.php' as $subscriberClass) {
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
