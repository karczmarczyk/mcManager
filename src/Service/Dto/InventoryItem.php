<?php
namespace App\Service\Dto;

class InventoryItem
{
    private $slot;
    private $id;
    private $count;
    private $tags = [];

    /**
     * @return mixed
     */
    public function getSlot(): int
    {
        return $this->slot;
    }

    /**
     * @param mixed $slot
     */
    public function setSlot(int $slot): void
    {
        $this->slot = $slot;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function addTag ($tagName, $tagValue): void
    {
        $this->tags[$tagName] = $tagValue;
    }

    public function getTag ($tagName): string
    {
        return $this->tags[$tagName] ?? null;
    }
}