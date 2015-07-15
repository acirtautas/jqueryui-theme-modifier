<?php
/**
 * jQuery UI theme modifier for Composer.
 *
 * @author Alfonsas Cirtautas
 */

use Composer\Script\Event;

/**
 * Class modifier.
 */
class modifier {

    /**
     * Composer hook to execute.
     *
     * @param Event $event
     */
    public static function modify(Event $event)
    {
        $composer = $event->getComposer();
        $config   = $composer->getConfig();
        $io       = $event->getIO();

        $modify   = $config->has('jqueryui-theme-modify') ? $config->get('jqueryui-theme-modify') : array();
        $dir      = $config->has('jqueryui-theme-dir') ? $config->get('jqueryui-theme-dir') : 'components/jquery-ui/themes/base';

        if(!is_array($modify) || !count($modify)) {
            return;
        }

        if (!is_dir($dir)) {
            $io->write('Can not find jQuery UI theme dir '.$dir);
            return;
        }

        $io->write('Modifying jQuery UI theme ['.$dir.']');

        $pattern = '/(.[^\*:]+)\/\*\{([a-z]+)\}\*\//i';

        foreach (new DirectoryIterator($dir) as $fileInfo) {
            if($fileInfo->isDot() || $fileInfo->isDir()) continue;

            $filename = $fileInfo->getFilename();;

            $css  = file_get_contents($dir.'/'.$filename);

            preg_match_all($pattern, $css, $matches);

            $modified = 0;

            if(count($matches)) {
                foreach($matches[0] as $i => $data) {
                    $value = $matches[1][$i];
                    $name  = $matches[2][$i];

                    if(isset($modify[$name])){
                        $replace = ' '.$modify[$name];
                        $css = str_replace($data, $replace.'/*{'.$name.'}*/', $css, $count);

                        $modified += $count;
                    }
                }
            }

            if($modified) {
                $io->write('    '.$filename.' '.str_repeat('.', $modified));
                file_put_contents($dir.'/'.$filename, $css);
            }

        }
    }
} 
