<?php

namespace Helper;

use HttpException;

/**
 * Class Curl
 *
 * @author  Jock Jiang
 * @since   2018/4/20
 * @email jock.jiang@dadaabc.com
 *
 * @package Helper
 */
class Curl
{
    /**
     * @param       $url
     * @param       $requestData
     * @param array $extraOpts
     * @param bool  $isPost
     *
     * @return mixed
     * @throws HttpException
     * @throws \ErrorException
     */
    public static function curl($url, $requestData, $extraOpts = [], $isPost = false)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT        => 200, //seconds
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        ]);
        if ($isPost) {
            if (is_array($requestData)) {
                $requestData = json_encode($requestData);
            }

            curl_setopt_array($ch, [
                CURLOPT_POST       => true,
                CURLOPT_POSTFIELDS => $requestData,
            ]);
        }

        curl_setopt_array($ch, $extraOpts);

        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            $err = sprintf("curl[%d]%s", curl_errno($ch), curl_error($ch));
            curl_close($ch);
            throw new \ErrorException($err);
        }

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode != 200) {
            curl_close($ch);
            throw new HttpException($httpcode, $data);
        }

        curl_close($ch);

        return $data;
    }

    /**
     * @param       $url
     * @param       $requestData
     * @param array $extraOpts
     *
     * @return mixed
     * @throws HttpException
     * @throws \ErrorException
     */
    public static function post($url, $requestData, $extraOpts = [])
    {
        return self::curl($url, $requestData, $extraOpts, true);
    }

    /**
     * @param       $url
     * @param       $requestData
     * @param array $extraOpts
     *
     * @return mixed
     * @throws HttpException
     * @throws \ErrorException
     */
    public static function get($url, $requestData, $extraOpts = [])
    {
        if (is_array($requestData)) {
            $requestData = http_build_query($requestData);
        }

        if (strpos($url, '?') === false) {
            $url = $url . '?' . $requestData;
        } else {
            $url = $url . '&' . $requestData;
        }

        return self::curl($url, null, $extraOpts, false);
    }


    /**
     * file download
     *
     * @param string $url
     * @param string $patch
     * @param int    $timeout
     *
     * @return mixed
     */
    public static function downloadFile(string $url, string $patch = '', int $timeout = 5)
    {
        set_time_limit(0);

        if ($patch) {
            $fp = fopen($patch, 'w');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        if ($patch) {
            curl_setopt($ch, CURLOPT_FILE, $fp);
        }

        $res  = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($patch) {
            fclose($fp);
            return $info;
        } else {
            return $res;
        }
    }
}