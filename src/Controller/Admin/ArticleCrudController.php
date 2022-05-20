<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Portfolio-Administration des Articles')
            ->setEntityLabelInPlural('Articles')
            ->setEntityLabelInSingular('Article')
            ->setDefaultSort(['id'=> 'DESC'])
            ->setPageTitle('new', 'Ajout d\'un article')
            ->setPageTitle('edit', 'Modification d\'un article')
            ->showEntityActionsInlined();

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('title'),
            TextareaField::new('content'),
            TextField::new('linkUrl'),
            DateTimeField::new('createdAt')->hideOnForm(),
            SlugField::new('slug')
                ->setTargetFieldName('title')->hideOnIndex(),

        ];
    }

}
