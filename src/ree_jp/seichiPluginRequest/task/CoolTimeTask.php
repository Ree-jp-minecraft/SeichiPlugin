<?php

namespace ree_jp\seichiPluginRequest\event;


use pocketmine\scheduler\Task;
use ree_jp\seichiPluginRequest\Skill;

class CoolTimeTask extends Task
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $n)
    {
        $this->name = $n;
        Skill::setCool($n, true);
    }

    /**
     * @inheritDoc
     */
    public function onRun(int $currentTick)
    {
        Skill::setCool($this->name, false);
    }
}