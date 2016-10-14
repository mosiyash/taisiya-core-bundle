<?php

namespace Taisiya\CoreBundle\Composer;

use Composer\EventDispatcher\Event;
use Composer\EventDispatcher\EventDispatcher;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Taisiya\CoreBundle\App;
use Taisiya\CoreBundle\Composer\Event\DefaultCommandSubscriberInterface;

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

        /** @var EventDispatcher $dispatcher */
        $dispatcher = $event->getComposer()->getEventDispatcher();

        $defaultCommandEvent = new Event(self::EVENT_DEFAULT_COMMAND, ['app' => $app]);

        /** @var string $subscriberClass */
        foreach (self::getComposerSubscribers() as $subscriberClass) {
            $reflectionClass = new \ReflectionClass($subscriberClass);
            if ($reflectionClass->isSubclassOf(DefaultCommandSubscriberInterface::class)) {
                $dispatcher->addSubscriber(new $subscriberClass());
            }
        }

        $dispatcher->dispatch(self::EVENT_DEFAULT_COMMAND, $defaultCommandEvent);
    }

    /**
     * @return array
     */
    final protected static function getComposerSubscribers(): array
    {
        return require_once TAISIYA_ROOT.'/var/cache/composer_subscribers.cache.php';
    }

    /**
     * @param Event $event
     */
    public static function copySettings(Event $event): void
    {
        $finder = new Finder();
        $finder
            ->in([
                TAISIYA_ROOT.'/vendor',
                TAISIYA_ROOT.'/src',
            ])
            ->files()
            ->name('/settings\.default\.php$/')
            ->filter(function (SplFileInfo $file) {
                return (bool) preg_match('/\/app\/config\//', $file->getPathname());
            });

        foreach ($finder as $file) {
            $dest = preg_replace('/^.+?\/vendor\/(.+?)\/(.+?)\/.+?$/', TAISIYA_ROOT.'/app/config/\1.\2.settings.default.php', $file->getPathname());
            if (!copy($file->getPathname(), $dest)) {
                $event->getIO()->writeError('  - <error>Couldn\'t copy '.str_replace(TAISIYA_ROOT.'/', '', $file->getPathname()).' to '.str_replace(TAISIYA_ROOT.'/', '', $dest).'</error>');
            } else {
                $event->getIO()->write('  - <info>'.str_replace(TAISIYA_ROOT.'/', '', $file->getPathname()).' is copied to '.str_replace(TAISIYA_ROOT.'/', '', $dest).'</info>');
            }
        }
    }

    /**
     * @param Event $event
     */
    public static function mergeSettings(Event $event): void
    {
        $uname = php_uname('n');
        $files = [];

        $finder = new Finder();
        $finder
            ->in(TAISIYA_ROOT.'/app/config')
            ->files()
            ->name('/\.settings\.default\.php$/');

        foreach ($finder as $file) {
            $files[] = $file->getPathname();
        }

        $finder = new Finder();
        $finder
            ->in(TAISIYA_ROOT.'/app/config')
            ->files()
            ->name('/\.settings\.local\.php$/');

        foreach ($finder as $file) {
            $files[] = $file->getPathname();
        }

        $finder = new Finder();
        $finder
            ->in(TAISIYA_ROOT.'/app/config')
            ->files()
            ->name('/\.settings\.'.preg_quote($uname, '/').'\.local\.php$/');

        foreach ($finder as $file) {
            $files[] = $file->getPathname();
        }

        $files[] = TAISIYA_ROOT.'/app/config/settings.default.php';
        if (file_exists(TAISIYA_ROOT.'/app/config/settings.local.php')) {
            $files[] = TAISIYA_ROOT.'/app/config/settings.local.php';
        }
        if (file_exists(TAISIYA_ROOT.'/app/config/settings.'.$uname.'.local.php')) {
            $files[] = TAISIYA_ROOT.'/app/config/settings.'.$uname.'.local.php';
        }

        $settings = [];
        foreach ($files as $file) {
            $settings = array_merge_recursive($settings, require $file);
        }

        if (!file_put_contents(TAISIYA_ROOT.'/app/config/settings.php', "<?php\n\nreturn ".var_export($settings, true).";\n")) {
            $event->getIO()->writeError('  - <error>couldn\'t write app/config/settings.php</error>');
        } else {
            $event->getIO()->write('  - <info>writed to app/config/settings.php</info>');
        }
    }

    /**
     * @param Event $event
     */
    public static function createPhinxConfigFile(Event $event): void
    {
        $settings = require TAISIYA_ROOT.'/app/config/settings.php';

        if (empty($settings['phinx'])) {
            $event->getIO()->writeError('  - <error>phinx configuration is empty</error>');
        } elseif (!file_put_contents(TAISIYA_ROOT.'/phinx.php', "<?php\n\nreturn ".var_export($settings['phinx'], true).";\n")) {
            $event->getIO()->writeError('  - <error>couldn\'t write a file: '.TAISIYA_ROOT.'/phinx.php</error>');
        } else {
            $event->getIO()->write('  - <info>writed to '.TAISIYA_ROOT.'/phinx.php</info>');
        }
    }
}
