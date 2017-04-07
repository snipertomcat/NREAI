<?php
/**
 * Created by: Jesse Griffin
 * Date: 4/2/2017
 */

class File
{
    public static function getLastLine($filename)
    {
        $data = file($filename);
        $line = $data[count($data)-1];
        return $line;
    }

    public static function getAdminSetting($filename)
    {
        $fh = fopen($filename, 'r');
        $data = fgetcsv($fh);
        fclose($fh);
        return $data[0];

    }

}