<?php

namespace App\Notification;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class ContactNotification
{

    private MailerInterface $mailer;


    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

    }

    /**
     * @throws TransportExceptionInterface
     */
    public function notify(Contact $contact)
    {
        $to = 'nicolas.garcia@campusdulac.com';
        $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to($to)
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact
            ]);

        $this->mailer->send($email);
    }
}