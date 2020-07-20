<?php

namespace App\Form\Model;

class McServerForm
{
    /**
     *
     */
    private $serverStatus = false;

    /**
     * @return bool
     */
    public function getServerStatus()
    {
        return $this->serverStatus;
    }

    /**
     * @param bool $serverStatus
     */
    public function setServerStatus($serverStatus)
    {
        $this->serverStatus = $serverStatus;
    }


}