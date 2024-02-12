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
        $file = self::getFileObject($options);

        if ($options->header) {
            return self::getArrayWithHead($file);
        }

        return self::getArray($file);
    }

    private static function getArray($file)
    {
        $csv = [];

        foreach ($file as $line) {
            $csvs[] =  $line;
        }

        return $csv;
    }

    private static function getArrayWithHead($file)
    {
        $csv = [];

        $header = $file->current();

        foreach ($file as $line) {
            $csv[] = array_combine($header, $line);
        }

        array_shift($csv);

        return $csv;
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

    /**
     * Write.
     *
     * @param LaraCsv $options
     * @param array $array
     * @return void
     */
    public static function write(LaraCsv $options, array $array): void
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

    public static function update(LaraCsv $options, $eloquent_model, string $key): array
    {
        $models = [];

        $csv = self::read($options);

        foreach (self::read($options) as $inputs) {
            if (is_null($eloquent_model::find($key))) {
                $model = new $eloquent_model;

                $model->fill($inputs);

                $model->save();

                $models[] = $model;
            }
        }

        return $models;
    }
}
