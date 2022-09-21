<?php

namespace SMail\MailtrapService;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class SendMailService
 * @package SMail\MailtrapService
 * PHP Version 7.4
 */
class SMail
{
    /**
     * @var PHPMailer
     */
    private PHPMailer $PHPMailer;

    /**
     * @var string
     */
    private string $port = '2525';

    /**
     * @var string
     */
    private string $host = 'smtp.mailtrap.io';

    public function __construct()
    {
        $this->PHPMailer = new PHPMailer();
    }

    /**
     * Expected array credentials with user, password, mail_from and name_from keys
     *
     * Expected array sendData with to, to_name, subject and message keys
     *
     * @param array $credentials
     * @param array $sendData
     * @return array
     */
    public function calltrap(array $credentials, array $sendData): array
    {
        $to = $sendData['to'];
        $name = $sendData['to_name'];
        $subject = $sendData['subject'];
        $message = $sendData['message'];

        return $this->handleSend($credentials, $to, $name, $subject, $message);
    }

    /**
     * @param array $credentials
     * @param string $to
     * @param string $name
     * @param string $subject
     * @param string $message
     * @return array
     */
    private function handleSend(array $credentials, string $to, string $name, string $subject, string $message): array
    {
        $this->PHPMailer->IsSMTP();
        $this->PHPMailer->SMTPDebug = 0;
        $this->PHPMailer->Host = $this->host;
        $this->PHPMailer->SMTPAuth = true;
        $this->PHPMailer->Username = $credentials['user'];
        $this->PHPMailer->Password = $credentials['password'];
        $this->PHPMailer->SMTPSecure = 'tls';
        $this->PHPMailer->SMTPAutoTLS = 'yes';
        $this->PHPMailer->Port = $this->port;
        $this->PHPMailer->isHTML();
        $this->PHPMailer->CharSet = 'UTF-8';
        $this->PHPMailer->setFrom($credentials['mail_from'], $credentials['name_from']);
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