<?php
/**
 * Created by PhpStorm.
 * User: kaduppg
 * Date: 3/3/19
 * Time: 8:24 PM
 */

namespace App\tests\Mailer;


use App\Entity\User;
use App\Mailer\Mailer;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{
    public function testConfirmationEmail(){
        $user = new User();
        $user->setEmail('john@doe.com');

        $swiftMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $swiftMailer->expects($this->once())->method('send')
            ->with($this->callback(function($subject){
                $messageStr = (string) $subject;
                return strpos($messageStr, 'From: blabla@bla.com') !== false;
            }));

        $twigMock = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twigMock->expects($this->once())->method('render')
            ->with('email/registration.html.twig',
                [
                    'user'=>$user
                ]);


        $mailer = new Mailer($swiftMailer, $twigMock, 'blabla@bla.com');
        $mailer->sendConfirmationEmail($user);

    }

}