<?php

/**
 * LaraCsv.
 */

namespace Antron\LaraCsv;

use SplFileObject;

/**
 * LaraCsv.
 */
class LaraCsvHelper
{
    /**
     * Read CSV File.
     *
     * @param string $file_path
     * @return array
     */
    public static function read(LaraCsv $options): array
    {
        $csvs = [];

        $file = self::getFileObject($options);

        if ($options->header) {
            $header = $file->current();

            foreach ($file as $line) {
                $csvs[] = array_combine($header, $line);
            }

            array_shift($csvs);

        } else {
            foreach ($file as $line) {
                $csvs[] =  $line;
            }
        }

        return $csvs;
    }

    /**
     * Get File Object.
     *
     * @param LaraCsv $options
     * @return SplFileObject
     */
    private static function getFileObject(LaraCsv $options): SplFileObject
    {
        $file = new SplFileObject($options->file_path);

        $file->setFlags(
            SplFileObject::READ_CSV |
                SplFileObject::READ_AHEAD |
                SplFileObject::SKIP_EMPTY
        );

        $file->setCsvControl($options->delimiter);

        return $file;
    }

    public static function write(LaraCsv $options, $array)
    {
        $string = '';

        foreach ($array as $cells) {
            $string .= implode($options->delimiter, $cells) . $options->returncode;
        }

        file_put_contents($options->file_path, $string);
    }

    public static function create(LaraCsv $options, $eloquent_model): array
    {
        $models = [];

        foreach (self::read($options) as $inputs) {
            $model = new $eloquent_model;

            $model->fill($inputs);

            $model->save();

            $models[] = $model;
        }

        return $models;
    }
}
