<?php

namespace App\Entity;

class OrdinateursSearch
{

    /*
     * @var int|null
     */
    private $minRam;

    /*
     * @var int|null
     */
    private $maxRam;

    /**
     * @return mixed
     */
    public function getMaxRam()
    {
        return $this->maxRam;
    }

    /**
     * @param mixed $maxRam
     */
    public function setMaxRam($maxRam): void
    {
        $this->maxRam = $maxRam;
    }

    /**
     * @return mixed
     */
    public function getMinRam()
    {
        return $this->minRam;
    }

    /**
     * @param mixed $minRam
     */
    public function setMinRam($minRam): void
    {
        $this->minRam = $minRam;
    }

}