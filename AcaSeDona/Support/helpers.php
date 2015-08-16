<?php

if ( ! function_exists('getBasePath'))
{
    /**
     * getBasePath
     *
     * @return string
     */
    function getBasePath()
    {
        if (strlen(Flight::request()->base) == 1)
        {
            return getWebsiteUrl() . '/';
        }

        return getWebsiteUrl() . Flight::request()->base . '/';
    }
}


if ( ! function_exists('getAssetUrl'))
{
    /**
     * getAssetUrl
     *
     * @param string $asset_route
     * @return string
     */
    function getAssetUrl($asset_route)
    {
        $filename = getcwd() . '/' . $asset_route;

        if ( ! file_exists($filename))
        {
            return $asset_route;
        }

        $changed_date = filemtime($filename);

        return getBasePath() . $asset_route . '?q=' . $changed_date;
    }
}


if ( ! function_exists('http_login'))
{
    /**
     * http_login
     *
     * @param $user
     * @param $pass
     * @return string
     */
    function http_login($user, $pass)
    {
        // fix for when it's not available some server variables
        list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) =
            explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));

        if ( ! isset($_SERVER['PHP_AUTH_USER']))
        {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            print "Sorry - you need valid credentials to be granted access!\n";
            exit;
        } else
        {
            if (($_SERVER['PHP_AUTH_USER'] == $user) && ($_SERVER['PHP_AUTH_PW'] == $pass))
            {
                // logged in
                return true;
            } else
            {
                header("WWW-Authenticate: Basic realm=\"Private Area - Wrong user or pass!\"");
                header("HTTP/1.0 401 Unauthorized");
                print "Sorry - you need valid credentials to be granted access!\n";
                exit;
            }
        }
    }
}


if ( ! function_exists('getWebsiteUrl'))
{
    /**
     * getWebsiteUrl
     *
     * @return string
     */
    function getWebsiteUrl($cache = true)
    {
        $url = $_SERVER['SERVER_NAME'];
        $final_url = 'd2gkk86dhibgth.cloudfront.net'; // cached assets
        $final_url = $url; // super hot fix, for cached issue

        if(strpos($url, 'acasedona.com.ar') === false) {
            $final_url = $url;
        }

        if($cache === false) {
            $final_url = $url;
        }

        return "http://{$final_url}";
    }
}
