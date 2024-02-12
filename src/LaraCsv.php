<?php

/**
 * LaraCsv.
 */

namespace Antron\LaraCsv;

/**
 * LaraCsv.
 */
class LaraCsv
{
    /**
     * Delimiter.
     *
     * @var string
     */
    public string $delimiter;

    /**
     * File Path.
     *
     * @var string
     */
    public string $file_path;

    /**
     * Header.
     *
     * @var boolean
     */
    public bool $header;

    /**
     * Return Code.
     *
     * @var string
     */
    public string $returncode;

    /**
     * Constructer
     *
     * @param string $file_path
     */
    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;

        $this->delimiter = ',';

        $this->header = true;

        $this->returncode = "\n";
    }

    /**
     * Read CSV.
     *
     * @return array
     */
    public function read(): array
    {
        return LaraCsvHelper::read($this);
    }

    /**
     * Create.
     *
     * @param mix $eloquent_model
     * @return array
     */
    public function create($eloquent_model): array
    {
        return LaraCsvHelper::create($this, $eloquent_model);
    }

    /**
     * Update.
     *
     * @param mix $eloquent_model
     * @return array
     */
    public function update($eloquent_model, string $key): array
    {
        return LaraCsvHelper::update($this, $eloquent_model, $key);
    }

    /**
     * Write CSV
     *
     * @param array $array
     * @return void
     */
    public function write(array $array): void
    {
        LaraCsvHelper::write($this, $array);
    }
}
