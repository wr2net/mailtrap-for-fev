<?php

namespace App\SendMail\Services;

use App\SendMail\Interfaces\SendMailInterface;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class SendMailService
 * @package App\SendMail\Services
 * @template-implements SendMailInterface
 * PHP Version 7.4
 */
class SendMailService implements SendMailInterface
{
    /**
     * @var PHPMailer
     */
    private PHPMailer $PHPMailer;

    /**
     * @var string
     */
    private string $user;

    /**
     * @var string
     */
    private string $passwd;

    /**
     * @var string
     */
    private string $mailFrom;

    /**
     * @var string
     */
    private string $nameFrom;

    /**
     * @var string
     */
    private string $port = '2525';

    /**
     * @var string
     */
    private string $host = 'smtp.mailtrap.io';

    /**
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        $this->PHPMailer = new PHPMailer();

        $this->user = $credentials['user'];
        $this->passwd = $credentials['password'];
        $this->mailFrom = $credentials['email_from'];
        $this->nameFrom = $credentials['name_from'];
    }

    /**
     * @param $sendData
     * @return array
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendEmail($sendData): array
    {
        $to = $sendData['to'];
        $name = $sendData['to_name'];
        $subject = $sendData['subject'];
        $message = $sendData['message'];

        return $this->handleSend($to, $name, $subject, $message);
    }

    /**
     * @param $to
     * @param $name
     * @param $subject
     * @param $message
     * @return array
     * @throws \PHPMailer\PHPMailer\Exception
     */
    private function handleSend($to, $name, $subject, $message): array
    {
        $this->PHPMailer->IsSMTP();
        $this->PHPMailer->SMTPDebug = 0;
        $this->PHPMailer->Host = $this->host;
        $this->PHPMailer->SMTPAuth = true;
        $this->PHPMailer->Username = $this->user;
        $this->PHPMailer->Password = $this->passwd;
        $this->PHPMailer->SMTPSecure = 'tls';
        $this->PHPMailer->SMTPAutoTLS = 'yes';
        $this->PHPMailer->Port = $this->port;
        $this->PHPMailer->isHTML();
        $this->PHPMailer->CharSet = 'UTF-8';
        $this->PHPMailer->setFrom($this->mailFrom, $this->nameFrom);
        $this->PHPMailer->addAddress($to, $name);
        $this->PHPMailer->Subject = $subject;
        $this->PHPMailer->Body = $message;

        if ($this->PHPMailer->Send()) {
            return [
                'code' => 200,
                'message' => "Sended message!",
            ];
        }

        return [
            'code' => 500,
            'message' => $this->PHPMailer->ErrorInfo,
        ];
    }
}