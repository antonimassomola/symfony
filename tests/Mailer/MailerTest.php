<?php
/**
 * Created by PhpStorm.
 * User: antonimassomola
 * Date: 17/11/2018
 * Time: 11:44
 */

namespace App\Tests\Mailer;


use App\Entity\User;
use App\Mailer\Mailer;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{

    public function testConfirmationEmail()
    {
        $user = new User();
        $user->setEmail('john@doe.com');

        $swiftMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $swiftMailer->expects($this->once())->method('send')
            ->with($this->callback(function ($subject) {
                $messageStr = (string)$subject;

                return strpos($messageStr, "From: admin@admin.com")
                    && strpos($messageStr, "Subject: Hello")
                    && strpos($messageStr, "To: john@doe.com")
                    && strpos($messageStr, "This is a message body")
                    !== false;
            }));

        $twigMock = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twigMock->expects($this->once())->method('render')
            ->with(
                'email/registration.html.twig', [
                'user' => $user
            ])->willReturn('This is a message body');

        $mailer = new Mailer($swiftMailer, $twigMock, 'admin@admin.com');
        $mailer->sendConfirmationMail($user);
    }

}