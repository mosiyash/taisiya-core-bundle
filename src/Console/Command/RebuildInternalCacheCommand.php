<?php

namespace Taisiya\CoreBundle\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Taisiya\CoreBundle\Composer\Event\EventSubscriberInterface;
use Taisiya\CoreBundle\Console\Command\Command;
use Taisiya\CoreBundle\Console\Style\TaisiyaStyle;
use Taisiya\CoreBundle\Exception\InvalidArgumentException;
use Taisiya\CoreBundle\Exception\NotReadableException;
use Taisiya\CoreBundle\Exception\RuntimeException;
use Taisiya\CoreBundle\Provider\ServiceProvider;

class RebuildInternalCacheCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('cache:internal-rebuild')
            ->setDescription('Rebuild internal application cache');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new TaisiyaStyle($input, $output);

        $this->rebuildComposerSubscribersCache($io);
        $this->rebuildBundlesCache($io);
        $this->rebuildCommandsCache($io);
    }

    /**
     * @param TaisiyaStyle $io
     */
    final protected function rebuildComposerSubscribersCache(TaisiyaStyle $io): void
    {
        $io->isVerbose() && $io->writeln('Rebuild Composer subscribers cache');

        $subscribers = [];

        $finder = Finder::create()
            ->in(TAISIYA_ROOT)
            ->path('/(src|vendor)/')
            ->files()
            ->name('*Subscriber.php');

        foreach ($finder as $k => $file) {
            $subscriberClass = $this->extractClassNameFromFile($file->getPathname());
            try {
                $reflectionClass = new \ReflectionClass($subscriberClass);
            } catch (\ReflectionException $e) {
                continue;
            }
            if (!$reflectionClass->isAbstract() && $reflectionClass->isSubclassOf(EventSubscriberInterface::class)) {
                $io->isVerbose() && $io->writeln('  + '.$subscriberClass);
                $subscribers[] = $subscriberClass;
            }
        }

        $this->putDataToCacheFile('composer_subscribers.cache.php', $subscribers);
        $io->isVerbose() && $io->writeln('  Subscribers saved to <info>composer_subscribers.cache.php</info>');
    }

    /**
     * @param TaisiyaStyle $io
     */
    final protected function rebuildBundlesCache(TaisiyaStyle $io): void
    {
        $io->isVerbose() && $io->writeln('Rebuild bundles cache');

        $bundles = [];

        $finder = Finder::create()
            ->in(TAISIYA_ROOT)
            ->path('/(src|vendor)/')
            ->files()
            ->name('*ServiceProvider.php');

        foreach ($finder as $k => $file) {
            $bundleServiceProvider = $this->extractClassNameFromFile($file->getPathname());
            $reflectionClass = new \ReflectionClass($bundleServiceProvider);
            if (!$reflectionClass->isAbstract() && $reflectionClass->isSubclassOf(ServiceProvider::class)) {
                $io->isVerbose() && $io->writeln('  + '.$bundleServiceProvider);
                $bundles[] = $bundleServiceProvider;
            }
        }

        $this->putDataToCacheFile('bundles.cache.php', $bundles);
        $io->isVerbose() && $io->writeln('  Bundles saved to <info>bundles.cache.php</info>');
    }

    /**
     * @param TaisiyaStyle $io
     */
    final protected function rebuildCommandsCache(TaisiyaStyle $io): void
    {
        $io->isVerbose() && $io->writeln('Rebuild commands cache');

        $commands = [];

        $finder = Finder::create()
            ->in(TAISIYA_ROOT)
            ->path('/(src|vendor)/')
            ->files()
            ->name('*Command.php');

        foreach ($finder as $k => $file) {
            $commandClass = $this->extractClassNameFromFile($file->getPathname());
            try {
                $reflectionClass = new \ReflectionClass($commandClass);
            } catch (\ReflectionException $e) {
                continue;
            }
            if (!$reflectionClass->isAbstract() && $reflectionClass->isSubclassOf(Command::class)) {
                $io->isVerbose() && $io->writeln('  + '.$commandClass);
                $commands[] = $commandClass;
            }
        }

        $this->putDataToCacheFile('commands.cache.php', $commands);
        $io->isVerbose() && $io->writeln('  Commands saved to <info>commands.cache.php</info>');
    }

    /**
     * @param string $filepath
     * @throws RuntimeException
     * @return string
     */
    final protected function extractClassNameFromFile(string $filepath): string
    {
        $contents = $this->getFileContents($filepath);

        preg_match('/namespace\s+(.+?)\;/', $contents, $namespace);
        if (!is_array($namespace) || !array_key_exists(1, $namespace)) {
            $namespace = null;
        } else {
            $namespace = $namespace[1];
        }

        preg_match('/class\s+(\w+)/', $contents, $class);
        if (!array_key_exists(1, $class)) {
            throw new RuntimeException('Couldn\'t extract class from file '.$filepath);
        }
        $class = $class[1];

        return preg_replace('/\\+/', '\\', implode('\\', ['', $namespace, $class]));
    }

    /**
     * @param string $filepath
     * @throws InvalidArgumentException
     * @throws NotReadableException
     * @throws RuntimeException
     * @return string
     */
    final protected function getFileContents(string $filepath): string
    {
        if (!file_exists($filepath)) {
            throw new InvalidArgumentException('File '.$filepath.' not exists');
        } elseif (!is_file($filepath)) {
            throw new InvalidArgumentException('The '.$filepath.' is not a regular file');
        } elseif (!is_readable($filepath)) {
            throw new NotReadableException('File '.$filepath.' not readable');
        }

        $contents = file_get_contents($filepath);

        if ($contents === false) {
            throw new RuntimeException('Couldn\'t get contents from file '.$filepath);
        }

        return $contents;
    }

    /**
     * @param string $filename
     * @param array $data
     * @throws RuntimeException
     */
    final protected function putDataToCacheFile(string $filename, array $data): void
    {
        $cacheDir = TAISIYA_ROOT.'/var/cache';
        if (!file_exists($cacheDir)) {
            if (!mkdir($cacheDir, 0777, true)) {
                throw new RuntimeException('Couldn\'t create directory '.$cacheDir);
            }
        }
        if (!file_put_contents($cacheDir.'/'.$filename, "<?php\n\nreturn ".var_export($data, true).";\n")) {
            throw new RuntimeException('Couldn\'t write contents to file '.$cacheDir.'/'.$filename);
        }
    }
}
