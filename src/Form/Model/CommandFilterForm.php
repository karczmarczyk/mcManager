<?php


namespace App\Form\Model;


class CommandFilterForm
{
    private $all;
    private $asyncChatThread;
    private $serverThread;

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->all;
    }

    /**
     * @param mixed $all
     */
    public function setAll($all): void
    {
        $this->all = $all;
    }

    /**
     * @return mixed
     */
    public function getAsyncChatThread()
    {
        return $this->asyncChatThread;
    }

    /**
     * @param mixed $asyncChatThread
     */
    public function setAsyncChatThread($asyncChatThread): void
    {
        $this->asyncChatThread = $asyncChatThread;
    }

    /**
     * @return mixed
     */
    public function getServerThread()
    {
        return $this->serverThread;
    }

    /**
     * @param mixed $serverThread
     */
    public function setServerThread($serverThread): void
    {
        $this->serverThread = $serverThread;
    }


}