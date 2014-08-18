<?php

class StreamSocketClientConnector
{
    /**
     * Create a new client socket stream
     *
     * This is a generic way to open a client stream based on a URI. Specific sub-types of stream socket can be created
     * directly via their respective constructors.
     *
     * @param string $url
     * @param array $options
     * @return StreamPeerSocket
     */
    public function open($url, array $options = [])
    {
        // todo
    }
}
