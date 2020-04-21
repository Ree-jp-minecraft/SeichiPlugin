<?php

namespace ree_jp\seichiPluginRequest\sqlite;


use ree_jp\seichiPluginRequest\SeichiPlugin;
use ree_jp\seichiPluginRequest\Skill;
use SQLite3;

class SeichiHelper
{
    /**
     * @var SeichiHelper
     */
    private static $instance;

    /**
     * @var SQLite3
     */
    private $db;

    static function getInstance(): SeichiHelper
    {
        if (self::$instance === null) {
            self::$instance = new SeichiHelper(SeichiPlugin::getInstance()->getDataFolder().'\seichi.db');
        }
        return self::$instance;
    }

    function __construct(string $path)
    {
        $this->db = new SQLite3($path);
        $this->db->exec("CREATE TABLE IF NOT EXISTS user(name TEXT NOT NULL PRIMARY KEY ,level NUMBER NOT NULL ,xp NUMBER NOT NULL ,mana NUMBER NOT NULL ,skill TEXT NOT NULL ,skills TEXT NOT NULL)");
    }

    /**
     * @param string $n
     * @return bool
     */
    function isExists(string $n): bool
    {
        $stmt = $this->db->prepare('SELECT * FROM user WHERE (name = :n )');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        return !empty($stmt->execute()->fetchArray());
    }

    function create(string $n): bool
    {
        $json = json_encode(new Skill());
        if ($this->isExists($n)) return false;
        $stmt = $this->db->prepare('REPLACE INTO data VALUES (:n, :level, :xp, :mana, :skill, ;skills)');
        $stmt->bindParam(':name', $name, SQLITE3_TEXT);
        $stmt->bindValue(':level', 0, SQLITE3_INTEGER);
        $stmt->bindValue(':xp', 0, SQLITE3_INTEGER);
        $stmt->bindValue(':mana', 0, SQLITE3_FLOAT);
        $stmt->bindParam(':skill', $json, SQLITE3_TEXT);
        $stmt->bindParam(':skills', $json, SQLITE3_TEXT);
        $stmt->execute();
        return true;
    }

    /**
     * @param string $n
     * @param int $level
     * @return bool
     */
    function setLevel(string $n, int $level): bool
    {
        if (!$this->isExists($n)) return false;
        $stmt = $this->db->prepare('UPDATE user SET level = :level WHERE name = :n ');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        $stmt->bindValue(':level', $level, SQLITE3_INTEGER);
        $stmt->execute();
        return true;
    }

    /**
     * @param string $n
     * @return int
     */
    function getLevel(string $n): int
    {
        if (!$this->isExists($n)) return 0;
        $stmt = $this->db->prepare('SELECT level FROM user WHERE name = :n ');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        return current($stmt->execute()->fetchArray());
    }

    function setXp(string $n, int $xp): bool
    {
        if (!$this->isExists($n)) return false;
        $stmt = $this->db->prepare('UPDATE user SET xp = :xp WHERE name = :n ');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        $stmt->bindValue(':xp', $xp, SQLITE3_INTEGER);
        $stmt->execute();
        return true;
    }

    /**
     * @param string $n
     * @return int
     */
    function getXp(string $n): int
    {
        if (!$this->isExists($n)) return 0;
        $stmt = $this->db->prepare('SELECT xp FROM user WHERE name = :n ');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        return current($stmt->execute()->fetchArray());
    }

    /**
     * @param string $n
     * @param string $skill
     * @return bool
     */
    function setSkill(string $n, string $skill): bool
    {
        if (!$this->isExists($n)) return false;
        $stmt = $this->db->prepare('UPDATE user SET skill = :skill WHERE name = :n ');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        $stmt->bindValue(':skill', $skill, SQLITE3_INTEGER);
        $stmt->execute();
        return true;
    }

    /**
     * @param string $n
     * @return string
     */
    function getSkill(string $n): string
    {
        if (!$this->isExists($n)) return "";
        $stmt = $this->db->prepare('SELECT skill FROM user WHERE name = :n ');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        return current($stmt->execute()->fetchArray());
    }

    function setSkills(string $n, string $skills): bool
    {
        if (!$this->isExists($n)) return false;
        $stmt = $this->db->prepare('UPDATE user SET skills = :skills WHERE name = :n ');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        $stmt->bindValue(':skills', $skills, SQLITE3_INTEGER);
        $stmt->execute();
        return true;
    }

    function getSkills(string $n): string
    {
        if (!$this->isExists($n)) return "";
        $stmt = $this->db->prepare('SELECT skills FROM user WHERE name = :n ');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        return current($stmt->execute()->fetchArray());
    }

    function setMana(string $n, string $mana): bool
    {
        if (!$this->isExists($n)) return false;
        $stmt = $this->db->prepare('UPDATE user SET mana = :mana WHERE name = :n ');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        $stmt->bindValue(':mana', $mana, SQLITE3_INTEGER);
        $stmt->execute();
        return true;
    }

    function getMana(string $n): string
    {
        if (!$this->isExists($n)) return 0;
        $stmt = $this->db->prepare('SELECT mana FROM user WHERE name = :n ');
        $stmt->bindParam(':n', $n, SQLITE3_TEXT);
        return current($stmt->execute()->fetchArray());
    }
}