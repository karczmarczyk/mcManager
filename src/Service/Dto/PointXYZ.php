<?php
namespace App\Service\Dto;

class PointXYZ
{
    private $x;
    private $y;
    private $z;

    /**
     * @return mixed
     */
    public function getX(): int
    {
        return (int) $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x): void
    {
        $this->x = $x;
    }

    /**
     * @return mixed
     */
    public function getY(): int
    {
        return (int) $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y): void
    {
        $this->y = $y;
    }

    /**
     * @return mixed
     */
    public function getZ(): int
    {
        return (int) $this->z;
    }

    /**
     * @param mixed $z
     */
    public function setZ($z): void
    {
        $this->z = $z;
    }


}