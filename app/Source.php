<?php

namespace App;

class Source
{
    protected $id;
    protected $name;
    protected $handler;

    private static $sourcesCache;

    public function __construct($id, $name, $handler)
    {
        $this->id = $id;
        $this->name = $name;
        $this->handler = $handler;
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function handler()
    {
        return $this->handler;
    }

    public function subscribe($email)
    {
        return (new $this->handler)->handle($email);
    }

    public static function index($sources = [])
    {
        if (isset($sourcesCache)) {
            return self::$sourcesCache;
        }

        $result = array();
        foreach ($sources as $source) {
            array_push($result, new Source($source["id"], $source["name"], $source["handler"]));
        }

        self::$sourcesCache = $result;
        return $result;
    }

    public static function clearCache()
    {
        unset(self::$sourcesCache);
    }
}
