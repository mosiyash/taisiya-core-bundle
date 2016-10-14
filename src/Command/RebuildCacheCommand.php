<?php

namespace Taisiya\CoreBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Taisiya\CoreBundle\Console\Style\TaisiyaStyle;
use Taisiya\CoreBundle\Exception\InvalidArgumentException;
use Taisiya\CoreBundle\Exception\NotReadableException;
use Taisiya\CoreBundle\Exception\RuntimeException;
use Taisiya\CoreBundle\Provider\ServiceProvider;

class RebuildCacheCommand extends Command
{
    protected function configure()
    {
        $this->setName('cache:rebuild')
            ->setDescription('Rebuild internal application cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new TaisiyaStyle($input, $output);

        $io->section('Search bundles');

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
                $output->isVerbose() && $output->write('  + '.$bundleServiceProvider);
                $bundles[] = $bundleServiceProvider;
            }
        }

        $this->putDataToCacheFile('bundles_providers.cached.php', $bundles);
    }

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
