<?php
namespace App\Service;

use App\Service\Dto\Enchantment;
use App\Service\Dto\InventoryItem;
use App\Service\Dto\PointXYZ;

class NbtPlayerService
{
    public function getNbtTreeFromContent ($content)
    {
        $nbtService = new \Nbt\Service(new \Nbt\DataHandler());
        return $nbtService->readString($content);
    }

    /**
     * @param $tree
     * @return array
     */
    public function getInventory ($tree): array
    {
        $inventoryList = [];

        $Inventory = $tree->findChildByName('Inventory');
        foreach ($Inventory->getChildren() as $child) {

            $inventory = new InventoryItem();

            foreach($child->getChildren() as $item) {

                if ($item->getName() == 'Slot') {
                    $inventory->setSlot($item->getValue());
                }
                else if ($item->getName() == 'id') {
                    $inventory->setId($item->getValue());
                }
                else if ($item->getName() == 'Count') {
                    $inventory->setCount($item->getValue());
                }
                else if ($item->getValue()==NULL) {
                    foreach($item->getChildren() as $tag) {
                        if ($tag->getName() == 'Enchantments') {
                            // enchant - lista
                            $tagT = [];
                            foreach ($tag->getChildren() as $ttKey=>$t) {
                                $enchantment = new Enchantment();
                                foreach ($t->getChildren() as $tt) {
                                    if ($tt->getName() == "id") {
                                        $enchantment->setId($tt->getValue());
                                    }
                                    else if ($tt->getName() == "lvl") {
                                        $enchantment->setLvl($tt->getValue());
                                    }
                                    $tagT[$ttKey] = $enchantment;
                                }
                            }
                            $inventory->addTag($tag->getName(), $tagT);
                        } else {
                            // inne jednowymiarowe
                            $inventory->addTag($tag->getName(), $tag->getValue());
                        }
                    }
                }
            }

            $inventoryList[$inventory->getSlot()] = $inventory;
        }

        return $inventoryList;
    }

    /**
     * @param $tree
     * @return mixed
     */
    public function getXpLvl ($tree)
    {
        return $this->getSimpleValueOf($tree, "XpLevel");
    }

    /**
     * @param $tree
     * @return mixed
     */
    public function getXpP ($tree)
    {
        return $this->getSimpleValueOf($tree, "XpP");
    }

    /**
     * @param $tree
     * @return mixed
     */
    public function getHealth ($tree)
    {
        return $this->getSimpleValueOf($tree, "Health");
    }

    /**
     * @param $tree
     * @return mixed
     */
    public function getFoodExhaustionLvl ($tree)
    {
        return $this->getSimpleValueOf($tree, "foodExhaustionLevel");
    }

    /**
     * @param $tree
     * @return mixed
     */
    public function getFoodLvl ($tree)
    {
        return $this->getSimpleValueOf($tree, "foodLevel");
    }

    /**
     * @param $tree
     * @return mixed
     */
    public function getFirstPlayed ($tree)
    {
        $bukkit = $tree->findChildByName('bukkit');
        if (is_null($bukkit)) {
            return null;
        }
        return $this->getSimpleValueOf($bukkit, "firstPlayed");
    }

    /**
     * @param $tree
     * @return mixed
     */
    public function getLastPlayed ($tree)
    {
        $bukkit = $tree->findChildByName('bukkit');
        if (is_null($bukkit)) {
            return null;
        }
        return $this->getSimpleValueOf($bukkit, "lastPlayed");
    }

    /**
     * @param $tree
     * @return mixed
     */
    public function getSpawnXYZ ($tree)
    {
        $point = new PointXYZ();
        $point->setX($this->getSimpleValueOf($tree, "SpawnX"));
        $point->setY($this->getSimpleValueOf($tree, "SpawnY"));
        $point->setZ($this->getSimpleValueOf($tree, "SpawnZ"));
        return $point;
    }

    /**
     * @param $tree
     * @return mixed
     */
    public function getPosXYZ ($tree)
    {
        $point = new PointXYZ();
        $pos = $tree->findChildByName('Pos');
        foreach ($pos->getChildren() as $key=>$p) {
            if ($key==0) {
                $point->setX($p->getValue());
            } elseif ($key==1) {
                $point->setY($p->getValue());
            } elseif ($key==2) {
                $point->setZ($p->getValue());
            }
        }
        return $point;
    }

    /**
     * @param $tree
     * @param $value
     * @return mixed
     */
    private function getSimpleValueOf ($tree, $value)
    {
        if (is_null($tree->findChildByName($value)) || !is_object($tree->findChildByName($value))) {
            return null;
        }
        return $tree->findChildByName($value)->getValue();
    }
}