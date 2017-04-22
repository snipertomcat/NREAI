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

    public static function getLastLines($filename, $lines)
    {
        $data = file($filename);
        //grab $x last rates:
        $start = count($data) - $lines;
        $slice = array_slice($data, $start, $lines);
        $slice = self::spotCheck($slice);
        return array_slice($slice, 0, $lines);
    }

    private static function spotCheck($array)
    {
        foreach ($array as $idx => $quote) {
            $explode = explode(',', $quote);
            if (trim($explode[1]) == '.') {
                unset($array[$idx]);
            }
        }

        return $array;
    }

}