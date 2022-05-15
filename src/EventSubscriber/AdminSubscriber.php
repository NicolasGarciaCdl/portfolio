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
            BeforeEntityPersistedEvent::class =>['setArticleSlugAndUser'],
            BeforeEntityUpdatedEvent::class => ['setArticleUpdateSlugAndUser']
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

    public function setArticleSlugAndUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof Article){
            return;
        }
        $slug = $this->slugger->slug($entity->getTitle());
        $entity->setSlug($slug);
        $user = $this->security->getUser();
        $entity->setUser($user);
        $now = new \DateTime();
        $entity->setCreatedAt($now);
        if($entity->getUpdatedAT() == null){
            $entity->setUpdatedAt(new \DateTime());
        }
    }

    public function setArticleUpdateSlugAndUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof Article){
            return;
        }
        $slug = $this->slugger->slug($entity->getTitle());
        $entity->setSlug($slug);
        $user = $this->security->getUser();
        $entity->setUser($user);
        $now = new \DateTime();
        $entity->setUpdatedAt($now);
    }
}