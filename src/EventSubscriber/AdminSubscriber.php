<?php

namespace App\EventSubscriber;

use App\Model\TimestampedInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminSubscriber implements EventSubscriberInterface
{
    private $slugger;
    private $security;

    public function __construct(SluggerInterface $slugger, Security $security)
    {
        $this->slugger = $slugger;
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setEntityCreatedAt'],
            BeforeEntityUpdatedEvent::class => ['setEntityUpdatedAt'],

        ];
    }

    public function setEntityCreatedAt(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof TimestampedInterface){
            return;
        }
//        $user = $this->security->getUser();
//        $entity->setUser($user);
        $entity->setCreatedAt(new \DateTime());
        $entity->setUpdatedAt(new \DateTime());


    }
    public function setEntityUpdatedAt(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof TimestampedInterface){
            return;
        }
//        $user = $this->security->getUser();
//        $entity->setUser($user);
        $entity->setUpdatedAt(new \DateTime());
    }
}