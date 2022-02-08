<?php namespace App\Phase;

/**
 * Class StaticData
 *
 * Parent class for MusicKey and Release Class. Contains methods to use the data
 *
 * @package App\Phase
 */
class StaticData
{
    protected static $data;

    /**
     * Return all the data
     *
     * @return mixed
     */
    public static function all()
    {
        return static::$data;
    }

    /**
     * Get a value given a key
     *
     * @param $key
     * @return mixed
     */
    public static function value($key)
    {
        return static::$data[$key];
    }

    /**
     * Check if a given key exists in the data
     *
     * @param $key
     * @return bool
     */
    public static function valid($key)
    {
        return array_key_exists($key, static::$data);
    }
}