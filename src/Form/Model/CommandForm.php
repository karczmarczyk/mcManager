<?php


namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CommandForm
{
    /**
     * @var string|null
     * @Assert\NotBlank(message="Polecenie nie może być puste")
     */
    private $command;

    /**
     * @return string|null
     */
    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * @param string|null $command
     */
    public function setCommand(?string $command): void
    {
        $this->command = $command;
    }
}