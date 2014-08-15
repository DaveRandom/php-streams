<?php

abstract class DatagramSocket
{
    /**
     * Underlying socket resource
     *
     * @var resource
     */
    protected $socket;

    /**
     * The default remote address for send operations
     *
     * @var string
     */
    protected $defaultRemoteAddress = null;

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
