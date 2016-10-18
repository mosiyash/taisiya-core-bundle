<?php

namespace Taisiya\CoreBundle\Console\Command\Cache;

use PhpParser\Builder\Class_;
use PhpParser\Node;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Taisiya\CoreBundle\Console\Command\Command;
use Taisiya\CoreBundle\Console\Style\TaisiyaStyle;
use Taisiya\CoreBundle\Event\EventSubscriberInterface;
use Taisiya\CoreBundle\Exception\InvalidArgumentException;
use Taisiya\CoreBundle\Exception\NotReadableException;
use Taisiya\CoreBundle\Exception\RuntimeException;
use Taisiya\CoreBundle\Provider\ServiceProvider;

final class RebuildInternalCacheCommand extends Command
{
    const NAME = 'cache:rebuild-internal';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::NAME)
            ->setDescription('Rebuild internal application cache');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->rebuildEventsSubscribersCache($input, $output);
        $this->rebuildBundlesCache($input, $output);
        $this->rebuildCommandsCache($input, $output);
    }

    /**
     * @param TaisiyaStyle $io
     */
    final protected function rebuildEventsSubscribersCache(InputInterface $input, OutputInterface $output): void
    {
        $output->isVerbose() && $output->writeln('Rebuild events subscribers cache');

        $bundles = [];

        $finder = Finder::create()
            ->in(TAISIYA_ROOT)
            ->path('/(src|vendor)/')
            ->files()
            ->name('*Subscriber.php');

        foreach ($finder as $k => $file) {
            $bundleServiceProvider = $this->extractClassNameFromFile($file->getPathname());
            $reflectionClass       = new \ReflectionClass($bundleServiceProvider);
            if (!$reflectionClass->isAbstract() && $reflectionClass->isSubclassOf(EventSubscriberInterface::class)) {
                $output->isVerbose() && $output->writeln('  + '.$bundleServiceProvider);
                $bundles[] = $bundleServiceProvider;
            }
        }

        $this->putDataToCacheFile('events_subscribers.cache.php', $bundles);
        $output->isVerbose() && $output->writeln('  Subscribers saved to <info>events_subscribers.cache.php</info>');
    }

    /**
     * @param TaisiyaStyle $io
     */
    final protected function rebuildBundlesCache(InputInterface $input, OutputInterface $output): void
    {
        $output->isVerbose() && $output->writeln('Rebuild bundles cache');

        $bundles = [];

        $finder = Finder::create()
            ->in(TAISIYA_ROOT)
            ->path('/(src|vendor)/')
            ->files()
            ->name('*ServiceProvider.php');

        foreach ($finder as $k => $file) {
            $bundleServiceProvider = $this->extractClassNameFromFile($file->getPathname());
            $reflectionClass       = new \ReflectionClass($bundleServiceProvider);
            if (!$reflectionClass->isAbstract() && $reflectionClass->isSubclassOf(ServiceProvider::class)) {
                $output->isVerbose() && $output->writeln('  + '.$bundleServiceProvider);
                $bundles[] = $bundleServiceProvider;
            }
        }

        $this->putDataToCacheFile('bundles.cache.php', $bundles);
        $output->isVerbose() && $output->writeln('  Bundles saved to <info>bundles.cache.php</info>');
    }

    /**
     * @param TaisiyaStyle $io
     */
    final protected function rebuildCommandsCache(InputInterface $input, OutputInterface $output): void
    {
        $output->isVerbose() && $output->writeln('Rebuild commands cache');

        $commands = [];

        $finder = Finder::create()
            ->in(TAISIYA_ROOT)
            ->path('/(src|vendor)/')
            ->files()
            ->name('*Command.php');

        foreach ($finder as $k => $file) {
            $output->writeln($file->getPathname());
            $commandClass = $this->extractClassNameFromFile($file->getPathname());
            try {
                $reflectionClass = new \ReflectionClass($commandClass);
            } catch (\ReflectionException $e) {
                continue;
            }
            if (!$reflectionClass->isAbstract() && $reflectionClass->isSubclassOf(Command::class)) {
                $output->isVerbose() && $output->writeln('  + '.$commandClass);
                $commands[] = $commandClass;
            }
//            $stmts = $this->getParser()->parse($this->getFileContents($file->getPathname()));
//            if (!$this->isAbstractClass($stmts) && $this->isSubclassOf($stmts, Command::class)) {
//                $commandClass = $this->findClassNameInStmts($stmts);
//                $output->isVerbose() && $output->writeln('  + '.$commandClass);
//                $commands[] = $commandClass;
//            }

        }

        $this->putDataToCacheFile('commands.cache.php', $commands);
        $output->isVerbose() && $output->writeln('  Commands saved to <info>commands.cache.php</info>');
    }

    /**
     * @param string $filepath
     *
     * @throws RuntimeException
     *
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
     *
     * @throws InvalidArgumentException
     * @throws NotReadableException
     * @throws RuntimeException
     *
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
     * @param array  $data
     *
     * @throws RuntimeException
     */
    final protected function putDataToCacheFile(string $filename, array $data): void
    {
        $cacheDir = TAISIYA_ROOT.'/var/cache/internal';
        if (!file_exists($cacheDir)) {
            if (!mkdir($cacheDir, 0777, true)) {
                throw new RuntimeException('Couldn\'t create directory '.$cacheDir);
            }
        }
        if (!file_put_contents($cacheDir.'/'.$filename, "<?php\n\nreturn ".var_export($data, true).";\n")) {
            throw new RuntimeException('Couldn\'t write contents to file '.$cacheDir.'/'.$filename);
        }
    }

    /**
     * @return Parser
     */
    final protected function getParser(): Parser
    {
        return (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
    }

    /**
     * @param array|null $stmts
     * @return null|string
     */
    final private function findClassNameInStmts(array $stmts = null): ?string
    {
        $namespace = null;
        $class = null;

        /** @var Node\Stmt $stmt */
        foreach ($stmts as $stmt) {
            if ($stmt instanceof Node\Stmt\Namespace_) {
                $namespace = $stmt->name->toString();
            } elseif ($stmt instanceof Node\Stmt\Class_) {
                $class = $stmt->name;
            }
            if ($namespace && $class) {
                break;
            }
        }

        if ($namespace && $class) {
            return $namespace.'\\'.$class;
        } elseif ($class) {
            return $class;
        }

        return null;
    }

    /**
     * @param array|null $stmts
     * @return bool
     */
    final private function isAbstractClass(array $stmts = null): bool
    {
        if ($stmts) {
            /** @var Node\Stmt $stmt */
            foreach ($stmts as $stmt) {
                if ($stmt instanceof Node\Stmt\Class_ && $stmt->isAbstract()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param array|null $stmts
     * @param string $subClassName
     * @return bool
     */
    final private function isSubclassOf(array $stmts = null, string $subClassName): bool
    {
        if ($stmts) {
            $use = null;
            $useAlias = null;
            $extendedClassName = null;
            /** @var Node\Stmt $stmt */
            foreach ($stmts as $stmt) {
                if ($stmt instanceof Node\Stmt\Use_ && $stmt->uses[0]->name->toString() === $subClassName) {
                    $use = $stmt->uses[0]->name->toString();
                    $useAlias = $stmt->uses[0]->alias;
                } elseif ($stmt instanceof Node\Stmt\Class_) {
                    if ($stmt->extends) {
                        $extendedClassName = $stmt->extends->toString();
                    }
                }
            }
            if ($use && $extendedClassName && $useAlias === $extendedClassName) {
                return true;
            }
            return false;
        }
        return false;
    }
}
