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
    public $my_class;

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
    public function create(): array
    {
        return LaraCsvHelper::create($this);
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
