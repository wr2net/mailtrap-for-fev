<?php

namespace SMail\SendMail\Controllers\SendMailController;

use SMail\SendMail\Interfaces\SendMailInterface as SMail;

class SendMailController
{
    /**
     * @var SMail
     */
    private SMail $smail;

    /**
     * @param SMail $smail
     */
    public function __construct(SMail $smail)
    {
        $this->smail = $smail;
    }

    public function smail($credentials, $sendData)
    {
        return $this->smail->sendEmail($credentials, $sendData);
    }
}