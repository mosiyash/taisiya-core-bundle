<?php

namespace Taisiya\CoreBundle\Console\Command\Config;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Taisiya\CoreBundle\Console\Command\Command;
use Taisiya\CoreBundle\Console\Style\TaisiyaStyle;
use Taisiya\CoreBundle\Exception\RuntimeException;

final class RebuildSettingsCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('config:rebuild-settings')
            ->setDescription('Rebuild project settings');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new TaisiyaStyle($input, $output);

        $this->copySettings($io);
        $this->mergeSettings($io);
    }

    /**
     * @param TaisiyaStyle $io
     * @throws RuntimeException
     */
    final protected function copySettings(TaisiyaStyle $io): void
    {
        $io->isVerbose() && $io->writeln('Copy bundles settings to project');

        $finder = Finder::create()
            ->in(TAISIYA_ROOT)
            ->path('vendor')
            ->files()
            ->name('settings.default.php')
            ->filter(function (SplFileInfo $file) {
                return (bool) preg_match('/\/app\/config\//', $file->getPathname());
            });

        foreach ($finder as $file) {
            exit(var_dump($file->getPathname()));
            $dest = preg_replace('/^.+?\/vendor\/(.+?)\/(.+?)\/.+?$/', TAISIYA_ROOT.'/app/config/\1.\2.settings.default.php', $file->getPathname());
            if (!copy($file->getPathname(), $dest)) {
                throw new RuntimeException('Couldn\'t copy '.str_replace(TAISIYA_ROOT.'/', '', $file->getPathname()).' to '.str_replace(TAISIYA_ROOT.'/', '', $dest));
            } else {
                $io->writeln('  - '.str_replace(TAISIYA_ROOT.'/', '', $file->getPathname()).' is copied to <info>'.str_replace(TAISIYA_ROOT.'/', '', $dest).'</info>');
            }
        }
    }

    /**
     * @param TaisiyaStyle $io
     * @throws RuntimeException
     */
    final protected function mergeSettings(TaisiyaStyle $io): void
    {
        $io->isVerbose() && $io->writeln('Merge settings into one file');

        $uname = php_uname('n');
        $files = [];

        $finder = Finder::create()
            ->in(TAISIYA_ROOT)
            ->path('app/config')
            ->files()
            ->name('/\.settings\.default\.php$/');

        foreach ($finder as $file) {
            $files[] = $file->getPathname();
        }

        $finder = Finder::create()
            ->in(TAISIYA_ROOT)
            ->path('app/config')
            ->files()
            ->name('/\.settings\.local\.php$/');

        foreach ($finder as $file) {
            $files[] = $file->getPathname();
        }

        $finder = Finder::create()
            ->in(TAISIYA_ROOT)
            ->path('app/config')
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
            throw new RuntimeException('Couldn\'t write to the file '.TAISIYA_ROOT.'/app/config/settings.php');
        } else {
            $io->writeln('  - writed to <info>app/config/settings.php</info>');
        }
    }
}
