<?php

namespace ree_jp\seichiPluginRequest\event;


use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use ree_jp\seichiPluginRequest\Skill;
use ree_jp\seichiPluginRequest\sqlite\SeichiHelper;
use ree_jp\stackStorage\api\StackStorageAPI;

class EventListener implements Listener
{
    function onJoin(PlayerJoinEvent $ev)
    {
        $p = $ev->getPlayer();
        $n = $p->getName();

        SeichiHelper::getInstance()->isExists($n);
    }

    function onBreak(BlockBreakEvent $ev)
    {
        $p = $ev->getPlayer();
        $n = $p->getName();
        $item = $ev->getItem();
        $level = $ev->getBlock()->getLevel();

        if (Skill::isCool($n)) {
            if (StackStorageAPI::getInstance()->getXuid($n) === null) {
                $p->sendMessage("ストレージにアイテムを入れることが出来ませんでした");
            } else foreach ($ev->getDrops() as $drop) StackStorageAPI::getInstance()->add($p->getXuid(), $drop);
        } else {
            $skill = Skill::decode(SeichiHelper::getInstance()->getSkill($n));
            Skill::setCool($n, true);
            foreach ($skill->skillRange($ev->getBlock()->asVector3(), $p->getDirection()) as $vec3) {
                $level->useBreakOn($vec3, $item, $p);
            }
            Skill::setCool($n, false);
            $ev->setCancelled();
        }
    }
}