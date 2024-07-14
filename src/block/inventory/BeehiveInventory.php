<?php

declare(strict_types=1);

namespace nicholass003\campfire\block\inventory;

use pocketmine\inventory\BaseInventory;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;

class BeehiveInventory extends BaseInventory {

    private Vector3 $holder;

    public function __construct(Vector3 $holder) {
        $this->holder = $holder;
        parent::__construct();
    }

    public function getHolder() : Vector3 {
        return $this->holder;
    }

    public function getName() : string {
        return "BeehiveInventory";
    }

    public function setItem(int $index, Item $item, bool $send = true) : void {
        parent::setItem($index, $item, $send);
    }

    public function addItem(Item ...$slots) : array {
        $result = parent::addItem(...$slots);
        return $result;
    }

    public function removeItem(Item ...$slots) : array {
        $result = parent::removeItem(...$slots);
        return $result;
    }

    protected function internalSetItem(int $index, Item $item): void
    {
        // TODO: Implement internalSetItem() method.
    }

    protected function internalSetContents(array $items): void
    {
        // TODO: Implement internalSetContents() method.
    }

    public function getSize(): int
    {
        return 1;
    }

    public function getItem(int $index): Item
    {
        return VanillaItems::AIR();
    }

    public function getContents(bool $includeEmpty = false): array
    {
        return [];
    }
}
