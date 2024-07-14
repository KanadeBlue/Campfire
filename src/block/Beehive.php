<?php

declare(strict_types=1);

namespace nicholass003\campfire\block;

use pocketmine\block\Block;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockTypeInfo;
use pocketmine\block\Transparent;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\block\utils\SupportType;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Beehive extends Transparent{
    use FacesOppositePlacingPlayerTrait;
    use HorizontalFacingTrait;

    private int $beeCount = 0;
    private $honey;

    public function __construct(BlockIdentifier $idInfo, string $name, BlockTypeInfo $typeInfo){
        parent::__construct($idInfo, $name, $typeInfo);
    }

    public function getSupportType(int $facing) : SupportType{
        return SupportType::NONE();
    }

    public function hasEntityCollision() : bool{
        return true;
    }

    public function isAffectedBySilkTouch() : bool{
        return true;
    }

    public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
        if(!$this->getSide(Facing::DOWN)->getSupportType(Facing::UP)->hasCenterSupport()){
            return false;
        }
        return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
    }

    public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []) : bool{
        if($player !== null && $this->getBeeCount() >= 1){
            if ($item instanceof (VanillaItems::GLASS_BOTTLE())) {
                $blockBelow = $this->getSide(Facing::DOWN);
                if ($blockBelow instanceof Campfire && !$blockBelow->isExtinguished() && $this->getHiveState()) {
                    if ($player->getInventory()->canAddItem(VanillaItems::HONEY_BOTTLE())){
                        $emptyBottle = $player->getInventory()->getItemInHand();
                        if ($emptyBottle->equals(VanillaItems::GLASS_BOTTLE())) {
                            $emptyBottle->pop();
                            $player->getInventory()->setItemInHand($emptyBottle);
                            $player->getInventory()->addItem(VanillaItems::HONEY_BOTTLE());
                        }
                    }
                }
            }
        }
        return false;
    }




    public function getBeeCount(): int {
        return $this->beeCount;
    }

    public function addBee(): void {
        if ($this->beeCount < 3) {
            $this->beeCount++;
        }
    }

    public function changeHiveState(): void
    {
        if ($this->honey !== true) {
            $this->honey = true;
        } else {
            $this->honey = false;
        }
    }

    public function getHiveState(): bool
    {
        return $this->honey;
    }

    public function removeBee(): void {
        if ($this->beeCount > 0) {
            $this->beeCount--;
        }
    }
}
