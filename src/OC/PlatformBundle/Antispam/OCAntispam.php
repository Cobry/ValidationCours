<?php
/**
 * Created by PhpStorm.
 * User: Punis_Port
 * Date: 12/03/2017
 * Time: 12:02
 */

namespace OC\PlatformBundle\Antispam;


class OCAntispam
{
    private $mailer;
    private $locale;
    private $minLength;

    /**
     * OCAntispam constructor.
     * @param \Swift_Mailer $mailer
     * @param $locale
     * @param $minLength
     */
    public function __construct(\Swift_Mailer $mailer, $locale, $minLength)
    {
        $this->mailer = $mailer;
        $this->locale = $locale;
        $this->minLength = (int)$minLength;
    }

    /**
     * @param $text
     * @return bool
     */
    public function isSpam($text){
        return strlen($text)< $this->minLength;
    }
}