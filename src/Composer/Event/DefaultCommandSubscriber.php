<?php

namespace Taisiya\CoreBundle\Composer\Event;

use Composer\EventDispatcher\Event;
use Taisiya\CoreBundle\App;
use Taisiya\CoreBundle\Composer\ScriptHandler;

final class DefaultCommandSubscriber implements DefaultCommandSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ScriptHandler::EVENT_DEFAULT_COMMAND => 'defaultCommandCallback',
        ];
    }

    /**
     * @param Event $event
     */
    public static function defaultCommandCallback(Event $event): void
    {
        /** @var App $app */
        $app = $event->getArguments()['app'];
    }
}
