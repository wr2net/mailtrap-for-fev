<?php

namespace SMail\SendMail\Interfaces;

/**
 * Interface SendMailInterface
 * @package App\SendMail\Interfaces
 * PHP Version 7.4
 */
interface SendMailInterface
{
    /**
     * @param array $credentials
     * @param array $sendData
     * @return array
     */
    public function sendEmail(array $credentials, array $sendData): array;
}