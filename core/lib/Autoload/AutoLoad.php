<?php

class AutoLoad
{

    function autoLoadClasses($dir = null)
    {
        $f3 = \Base::instance();
        $directoryList = glob($dir . "/*", GLOB_ONLYDIR);
        if (count($directoryList) == 0) {
            $f3->set('AUTOLOAD', $f3->get('AUTOLOAD') . ';' . $dir . '/');
            return;
        }
        foreach ($directoryList as $file) {
            $this->autoLoadClasses($file);
        }
    }


    function autoLoadTwig($dir)
    {
        $Directory = new RecursiveDirectoryIterator($dir);
        $Iterator = new RecursiveIteratorIterator($Directory);
        $Regex = new RegexIterator($Iterator, '/^.+(.html?g|.html)$/i', RecursiveRegexIterator::GET_MATCH);
        $routes = array();
        foreach ($Regex as $name=>$regex) {
            $pos = strrpos($name, DIRECTORY_SEPARATOR);
            $routes[] = substr($name, 0, $pos + 1);
        }
        return array_unique($routes);
    }
}