<?php

namespace App\Controller\Admin;

use App\Entity\Language;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
            ->setDefaultSort(['id'=> 'DESC'])
            ->setPageTitle('new', 'Ajout de langage et framework')
            ->setPageTitle('edit', 'Modification du langage et framework')
            ->showEntityActionsInlined();

    }

    public function configureActions(Actions $actions): Actions
    {
          return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Ajouter');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function(Action $action){
                return $action->setLabel('Enregistrer et ajouter un nouveau');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function(Action $action){
                return $action->setLabel('Enregistrer');
            })
              ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function(Action $action){
                  return $action->setLabel('Enregistrer et continuer');
              })
              ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function(Action $action){
                  return $action->setLabel('Enregistrer');
              })
              ;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextField::new('imageFile', 'image',)->setFormType(VichImageType::class)->onlyWhenCreating(),
            DateTimeField::new('updatedAt', 'Mis à jour le')
                ->hideOnForm(),
        ];
    }

}
