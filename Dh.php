<?php

/**
 * Class Dh
 * Date helper
 *
 * @author Chiang
 * @since  2018/4/18
 * @email  chiangzg@gmail.com
 *
 */
class Dh
{
    const INTERVAL_DAY = 86400;
    const INTERVAL_HOUR = 3600;
    const INTERVAL_MINUTE = 60;

    /**
     * @param string $format
     *
     * @return false|string
     */
    public static function now(string $format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    /**
     * @return mixed
     */
    public static function microtime()
    {
        return microtime(true);
    }

    /**
     * @param int    $seconds
     * @param string $format
     *
     * @return false|string
     */
    public static function ago(int $seconds, string $format = 'Y-m-d H:i:s')
    {
        return date($format, time() - $seconds);
    }

    /**
     * @param int    $seconds
     * @param string $format
     *
     * @return false|string
     */
    public static function later(int $seconds, string $format = 'Y-m-d H:i:s')
    {
        return date($format, time() + $seconds);
    }

    /**
     * @param        $dateStr
     * @param string $format
     *
     * @return bool
     */
    public static function validate($dateStr, $format = 'Y-m-d H:i:s')
    {
        return date($format, strtotime($dateStr)) == $dateStr;
    }

    /**
     * @param $dateStr
     *
     * @return bool|string
     */
    public static function date($dateStr)
    {
        return substr($dateStr, 0, 10);
    }

    /**
     * @param $dateStr
     *
     * @return bool|string
     */
    public static function time($dateStr)
    {
        return substr($dateStr, 11);
    }

    /**
     * @param $dateStr
     *
     * @return bool|string
     */
    public static function hour($dateStr)
    {
        return substr($dateStr, 11, 2);
    }

    /**
     * @param $dateStr
     *
     * @return bool|string
     */
    public static function minute($dateStr)
    {
        return substr($dateStr, 14, 2);
    }

    /**
     * @param int    $timestamp
     * @param string $format
     *
     * @return false|string
     */
    public static function toDate(int $timestamp, string $format = 'Y-m-d H:i:s')
    {
        return date($format, $timestamp);
    }
}