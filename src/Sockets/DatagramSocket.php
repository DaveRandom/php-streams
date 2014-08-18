<?php

abstract class DatagramSocket extends StreamSocket
{
    /**
     * The default remote address for send operations
     *
     * @var string
     */
    protected $defaultRemoteAddress = null;

    /**
     * Get a list of the URI schemes that this type of stream can handle
     *
     * @return array
     */
    protected function getSupportedSchemes()
    {
        static $schemes = null;

        if ($schemes === null) {
            $schemes = ['udp'];

            if (in_array('udg', stream_get_transports())) {
                $schemes[] = 'udg';
            }
        }

        return $schemes;
    }

    /**
     * Userland implementation detail
     *
     * @param string|Datagram $data
     * @param string $address
     * @throws \LogicException
     * @return array
     */
    private function normalizeDataAndAddress($data, $address)
    {
        if ($address === null) {
            if ($data instanceof Datagram) {
                return [$data->data, $data->remoteAddress];
            } else if ($this->defaultRemoteAddress !== null) {
                return [(string)$data, $this->defaultRemoteAddress];
            } else {
                throw new \LogicException('Remote address is unspecified');
            }
        }

        return [(string)$data, (string)$address];
    }

    /**
     * Send some data to a remote socket
     *
     * @param string|Datagram $data
     * @param int $flags
     * @param string $address
     * @throws \LogicException
     * @return int
     */
    public function send($data, $flags = null, $address = null)
    {
        list($data, $address) = $this->normalizeDataAndAddress($data, $address);
        return stream_socket_sendto($this->socket, $data, $flags, $address);
    }

    /**
     * Receive some data from the remote socket as a Datagram
     *
     * @param int $length
     * @param int $flags
     * @return Datagram|null
     */
    public function recv($length = null, $flags = 0)
    {
        $data = stream_socket_recvfrom($this->socket, $length !== null ? (int)$length : 1024, $flags, $address);
        return $data ? new Datagram($data, $address) : null;
    }
}
