<?php

namespace Artstorm\MonkeyLearn\HttpClient;

class CurlClient
{
    /**
     * cURL handle.
     *
     * @var resource
     */
    protected $handle = null;

    /**
     * Assign dependencies.
     */
    public function __construct()
    {
        $this->handle = curl_init();
    }

    /**
     * Set an option on the resource handle.
     *
     * @param  int   $name
     * @param  mixed $value
     *
     * @return void
     */
    public function setOption($name, $value)
    {
        curl_setopt($this->handle, $name, $value);
    }

    /**
     * Get info about the current cURL resource.
     *
     * @return void
     */
    public function getInfo()
    {
        return curl_getinfo($this->handle);
    }

    /**
     * Execute the request.
     *
     * @return mixed
     */
    public function execute()
    {
        return curl_exec($this->handle);
    }

    /**
     * Get error from the cURL call.
     *
     * @return string
     */
    public function error()
    {
        return curl_error($this->handle);
    }

    /**
     * Close the cURL session.
     *
     * @return void
     */
    public function close()
    {
        curl_close($this->handle);
    }
}
