<?php

namespace App\Controller\Admin;

use App\Entity\Language;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LanguageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Language::class;
    }

    /**
     * @param Crud $crud
     * @return Crud
     * configure l'affichage dans le dashboard/language
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Portfolio-Administration des Langages et Frameworks')
            ->renderSidebarMinimized()
            ->setEntityLabelInPlural('Langages et Frameworks')
            ->setEntityLabelInSingular('Langage et Framework')
            ->setDefaultSort(['id'=> 'DESC']);


    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextEditorField::new('image_name', 'image')
                ->hideOnForm(),

            DateTimeField::new('updatedAt', 'Mis à jour le')
                ->hideOnForm(),
        ];
    }

}
