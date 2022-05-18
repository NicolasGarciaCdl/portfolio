<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Portfolio-Administration des projets')
            ->setEntityLabelInPlural('Projets')
            ->setEntityLabelInSingular('Projet')
            ->setDefaultSort(['createdAt'=> 'DESC'])
            ->setPageTitle('new', 'Ajout de projet')
            ->setPageTitle('edit', 'Modification du projet')
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
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
