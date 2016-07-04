<?php


/**
 * Interface Provider
 */
interface Provider
{
    /**
     * @param $base_url
     * @param $permissions
     * @return mixed
     */
    public function getRedirectUrl();

    /**
     * @return mixed
     */
    public function setAccessToken();

    /**
     * @return mixed
     */
    public function getPayLoad();
}