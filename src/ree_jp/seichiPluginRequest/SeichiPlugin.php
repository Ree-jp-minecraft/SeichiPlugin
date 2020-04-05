<?php

namespace ree_jp\seichiPluginRequest;


use pocketmine\plugin\PluginBase;

class SeichiPlugin extends PluginBase
{
    /**
     * @var SeichiPlugin
     */
    private static $instance;

    public function onLoad()
    {
        self::$instance = $this;
        parent::onLoad();
    }

    public function onEnable()
    {
        parent::onEnable();
    }

    /**
     * @return SeichiPlugin
     */
    public static function getInstance(): SeichiPlugin
    {
        return self::$instance;
    }
}