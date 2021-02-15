<?php

namespace App\Service\Dto;

class StatDTO
{
    static $DESC = "DESC";
    static $ASC = "ASC";

    private $category;
    private $key;
    private $sort;

    /**
     * StatDTO constructor.
     * @param $category
     * @param $key
     * @param string $sort
     */
    public function __construct($category, $key, $sort = "DESC")
    {
        $this->category = $category;
        $this->key = $key;
        $this->sort = $sort;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getSort(): string
    {
        return $this->sort;
    }


}