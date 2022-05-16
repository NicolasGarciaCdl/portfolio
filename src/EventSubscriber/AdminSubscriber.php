<?php

namespace App\EventSubscriber;

use App\Entity\Article;
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
            BeforeEntityPersistedEvent::class =>['setDateAndUser'],
            BeforeEntityUpdatedEvent::class => ['setArticleUpdateDateAndUser']
        ];
    }

    public function setEntityCreatedAt(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof TimestampedInterface){
            return;
        }

        $entity->setCreatedAt(new \DateTime());
    }
    public function setEntityUpdatedAt(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof TimestampedInterface){
            return;
        }
        $entity->setUpdatedAt(new \DateTime());
    }

    public function setDateAndUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof Article){
            return;
        }

        $user = $this->security->getUser();
        $entity->setUser($user);
        $now = new \DateTime();
        $entity->setCreatedAt($now);
        if($entity->getUpdatedAT() == null){
            $entity->setUpdatedAt(new \DateTime());
        }
    }

    public function setArticleUpdateDateAndUser(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof Article){
            return;
        }
        $user = $this->security->getUser();
        $entity->setUser($user);
        $now = new \DateTime();
        $entity->setUpdatedAt($now);
    }
}