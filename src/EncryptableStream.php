<?php

interface EncryptableStream
{
    /**
     * Enable encryption on a stream
     *
     * @param int $type
     * @param EncryptableStream $sessionSteam
     * @return int|bool
     */
    public function enableEncryption($type = null, EncryptableStream $sessionSteam = null);

    /**
     * Disable encryption on a stream
     *
     * @return int|bool
     * @todo look into possible return values here
     */
    public function disableEncryption();
}
