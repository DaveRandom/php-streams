<?php

abstract class StreamSocket extends Stream
{
    /**
     * Class constants for shutdown type
     *
     * @todo probably no point in these
     */
    const SHUT_RD   = STREAM_SHUT_RD;
    const SHUT_WR   = STREAM_SHUT_WR;
    const SHUT_RDWR = STREAM_SHUT_RDWR;

    /**
     * Underlying socket resource
     *
     * @var resource
     */
    protected $socket;

    /**
     * Get a list of the URI schemes that this type of stream can handle
     *
     * @return array
     */
    protected function getSupportedSchemes()
    {
        static $schemes = null;

        if ($schemes === null) {
            $schemes = [];

            $supportableSchemes = ['tcp', 'unix', 'ssl', 'sslv2', 'sslv3', 'tls', 'tlsv1.0', 'tlsv1.1', 'tlsv1.2'];
            $availableSchemes = array_flip(stream_get_transports());

            foreach ($supportableSchemes as $scheme) {
                if (isset($availableSchemes[$scheme])) {
                    $schemes[] = $scheme;
                }
            }
        }

        return $schemes;
    }

    /**
     * Helper method to parse the URI supplied for the remote socket
     *
     * @param string $uri
     * @return array
     * @throws LogicException
     */
    protected function parseURI($uri)
    {
        if (false === $uriParts = parse_url($uri)) {
            throw new \LogicException('Invalid URI: parse operation failed');
        } else if (!isset($uriParts['scheme'])) {
            throw new \LogicException('Invalid URI: missing scheme');
        } else if (!in_array($uriParts['scheme'] = strtolower($uriParts['scheme']), $this->getSupportedSchemes())) {
            throw new \LogicException('Invalid URI: unsupported scheme ' . $uriParts['scheme']);
        }

        return $uriParts;
    }

    /**
     * Shutdown read, write or both activity types on the socket
     *
     * @param int $how
     * @throws \LogicException when the underlying socket has already been closed
     * @throws \RuntimeException when the shutdown operation fails
     */
    public function shutdown($how = self::SHUT_RDWR)
    {
        if ($this->socket === null) {
            throw new \LogicException('Failed to shut down socket: already closed');
        } else if (!stream_socket_shutdown($this->socket, $how)) {
            throw new \RuntimeException('Failed to shut down socket: operation failed');
        }
    }

    /**
     * Get the name (address/port) of the locally bound socket
     *
     * @return string
     * @throws \LogicException when the underlying socket has already been closed
     * @throws \RuntimeException when retrieving the name fails
     */
    public function getLocalName()
    {
        if ($this->socket === null) {
            throw new \LogicException('Cannot retrieve socket name: socket has been closed');
        } else if (false === $name = stream_socket_get_name($this->socket, false)) {
            throw new \RuntimeException('Cannot retrieve socket name: operation failed');
        }

        return $name;
    }

    /**
     * Close the stream
     *
     * @throws \LogicException when the underlying stream has already been closed
     * @throws \RuntimeException when the close operation fails
     */
    public function close()
    {
        if ($this->socket === null) {
            throw new \LogicException('Failed to shut down socket: already closed');
        } else if (!fclose($this->socket)) {
            throw new \RuntimeException('Failed to shut down socket: operation failed');
        }

        $this->socket = null;
    }
}
