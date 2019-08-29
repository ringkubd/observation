<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 1/20/2019
 * Time: 1:30 PM
 */

namespace App\helper;


class FileLoader extends \Illuminate\Config\FileLoader
{
    public function save($items, $environment, $group, $namespace = null)
    {
        $path = $this->getPath($namespace);

        if (is_null($path))
        {
            return;
        }

        $file = (!$environment || ($environment == 'production'))
            ? "{$path}/{$group}.php"
            : "{$path}/{$environment}/{$group}.php";

        $this->files->put($file, '<?php return ' . var_export($items, true) . ';');
    }
}
