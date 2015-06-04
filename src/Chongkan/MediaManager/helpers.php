<?php

if ( ! function_exists('mediaManager_style'))
{
    /**
     * @param $url
     * @param array $attributes
     * @param bool $secure
     * @return mixed
     */
    function mediaManager_style($url, $attributes = array(), $secure = false)
    {
        return HTML::style('packages/chongkan/media-manager/' . $url, $attributes, $secure);
    }
}

if ( ! function_exists('mediaManager_asset'))
{
    /**
     * Get Media Manager asset url.
     *
     * @param  string  $url
     * @param  boolean $secure
     * @return string
     */
    function mediaManager_asset($url, $secure = false)
    {
        return asset("packages/chongkan/media-manager/" . $url, $secure);
    }
}
