<?php


namespace ree_jp\seichiPluginRequest;


use pocketmine\math\Vector3;

class Skill
{
    /**
     * @var bool[]
     */
    private static $isCoolSkill;

    /**
     * @var string
     */
    public $name = "スキル無し";

    /**
     * @var int
     */
    public $height = 1;

    /**
     * @var int
     */
    public $width = 1;

    /**
     * @var int
     */
    public $depth = 1;

    static function decode(string $json): Skill
    {
        $array = json_decode($json);
        $class = new Skill();
        $class->name = $array->name;
        $class->height = $array->height;
        $class->width = $array->width;
        $class->depth = $array->depth;
        return $class;
    }

    static function create(string $name, int $height, int $width, int $depth): Skill
    {
        $class = new Skill();
        $class->name = $name;
        $class->height = $height;
        $class->width = $width;
        $class->depth = $depth;
        return $class;
    }

    /**
     * @param string $name
     * @return bool
     */
    static function isCool(string $name): bool
    {
        if (isset(self::$isCoolSkill[$name])) {
            if (self::$isCoolSkill[$name]) return true;
        }
        return false;
    }

    /**
     * @param string $name
     * @param bool $is
     */
    static function setCool(string $name, bool $is): void
    {
        self::$isCoolSkill = $is;
    }

    /**
     * @param Vector3 $vec3
     * @param int $direction
     * @return Vector3[]
     */
    function skillRange(Vector3 $vec3, int $direction): array
    {
        $result = [];
        $sy = -($this->height - 1) / 2;
        $my = ($this->height - 1) / 2;
        $sx = 0;
        $mx = 0;
        $sz = 0;
        $mz = 0;
        switch ($direction) { //0と1 2と3を入れ替えるかも
            case 0: //South
                $sx = -($this->width - 1) / 2;
                $mx = ($this->width - 1) / 2;
                $sz = 0;
                $mz = ($this->depth - 1);
                break;
            case 1: //West
                $sx = 0;
                $mz = ($this->depth - 1);
                $sz = -($this->width - 1) / 2;
                $mx = ($this->width - 1) / 2;
                break;
            case 2: //North
                $sx = -($this->width - 1) / 2;
                $mx = ($this->width - 1) / 2;
                $sz = -($this->depth - 1);
                $mz = 0;
                break;
            case 3: //East
                $sx = -($this->depth - 1);
                $mz = 0;
                $sz = -($this->width - 1) / 2;
                $mx = ($this->width - 1) / 2;
                break;
        }
        for ($x = $sx; $x <= $mx; $x++) {
            for ($y = $sy; $y <= $my; $y++) {
                for ($z = $sz; $z <= $mz; $z++) {
                    $result[] = $vec3->add($x, $y, $z);
                }
            }
        }
        return $result;
    }
}