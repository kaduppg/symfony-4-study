<?php
/**
 * Created by PhpStorm.
 * User: kaduppg
 * Date: 2/26/19
 * Time: 7:30 PM
 */

namespace App\Event;


use App\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{


    private $mailer;


    function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;

    }

    public static function getSubscribedEvents()
    {
       return [
           UserRegisterEvent::NAME => 'onUserRegister'
       ];

    }

    public function onUserRegister(UserRegisterEvent $event){
       $this->mailer->sendConfirmationEmail($event->getRegisteredUser());
    }
}