<?php

namespace Taisiya\CoreBundle\Console\Style;

use Symfony\Component\Console\Style\SymfonyStyle;

class TaisiyaStyle extends SymfonyStyle
{
    /**
     * Outputs a replacable line to the cli.
     * You can continue replacing the line until TRUE is passed as the second parameter
     * in order to indicate you are done modifying the line.
     * @param $messages
     * @param bool $endline Whether the line is done being replaced
     * @param int $type
     */
    public function writeReplace($messages, bool $endline = false, int $type = self::OUTPUT_NORMAL): void
    {
        if (!is_array($messages)) {
            $messages = [$messages];
        }

        if ($endline) {
            foreach ($messages as $k => $text) {
                $messages[$k] = $text.PHP_EOL;
            }
        }

        foreach ($messages as $k => $text) {
            $messages[$k] = "\r\033[K".$text;
        }

        parent::write($messages, false, $type);
    }
}
