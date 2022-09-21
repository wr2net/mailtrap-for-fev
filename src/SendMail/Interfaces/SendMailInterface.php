<?php

namespace App\SendMail\Interfaces;

/**
 * Interface SendMailInterface
 * @package App\SendMail\Interfaces
 * PHP Version 7.4
 */
interface SendMailInterface
{
    /**
     * @param array $credentials
     */
    public function __construct(array $credentials);

    /**
     * @param $sendData
     * @return array
     */
    public function sendEmail($sendData): array;
}