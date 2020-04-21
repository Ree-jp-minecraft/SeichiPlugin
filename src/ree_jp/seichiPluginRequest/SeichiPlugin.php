<?php

namespace ree_jp\seichiPluginRequest;


use pocketmine\plugin\PluginBase;

class SeichiPlugin extends PluginBase
{
    /**
     * @var SeichiPlugin
     */
    private static $instance;

    /**
     * @var Skill[]
     *
     * ここにスキルのリストを入れるとユーザーが持っていない名前の物があれば購入できるようになる
     */
    static $skills;

    public function onLoad()
    {
        self::$instance = $this;
        parent::onLoad();
    }

    public function onEnable()
    {
        $this->setSkill();
        parent::onEnable();
    }

    private function setSkill(): void
    {
        self::$skills = [
            [
                "level" => 1,
                "money" => 10000,
                "skill" => Skill::create("3×3×3", 3, 3, 3),
            ],
            [
                "level" => 1,
                "money" => 10000,
                "skill" => Skill::create("5×5×5", 5, 5, 5),
            ],
            [
                "level" => 1,
                "money" => 10000,
                "skill" => Skill::create("7×5×7", 7, 5, 7),
            ],
        ];
    }

    /**
     * @return SeichiPlugin
     */
    public static function getInstance(): SeichiPlugin
    {
        return self::$instance;
    }
}