<?php

namespace Taisiya\CoreBundle\Composer;

use Composer\EventDispatcher\Event;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Taisiya\CoreBundle\App;

defined('TAISIYA_ROOT') || define('TAISIYA_ROOT', dirname(dirname(__DIR__)));

class ScriptHandler
{
    const EVENT_DEFAULT_COMMAND = 'default_command';

    /**
     * @param Event $event
     */
    final public static function defaultCommand(Event $event): void
    {
        $app = file_exists(TAISIYA_ROOT.'/bootstrap.php')
            ? require_once TAISIYA_ROOT.'/bootstrap.php':
            new App();

//        /** @var EventDispatcher $dispatcher */
//        $dispatcher = $event->getComposer()->getEventDispatcher();
//
//        $defaultCommandEvent = new Event(self::EVENT_DEFAULT_COMMAND, ['app' => $app]);
//
//        /** @var string $subscriberClass */
//        foreach (self::getComposerSubscribers() as $subscriberClass) {
//            $reflectionClass = new \ReflectionClass($subscriberClass);
//            if ($reflectionClass->isSubclassOf(DefaultCommandSubscriberInterface::class)) {
//                $dispatcher->addSubscriber(new $subscriberClass());
//            }
//        }
//
//        $dispatcher->dispatch(self::EVENT_DEFAULT_COMMAND, $defaultCommandEvent);


    }
}
