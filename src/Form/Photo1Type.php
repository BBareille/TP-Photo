<?php

namespace App\Form;

use App\DataTransformer\TagTransformer;
use App\Entity\Folder;
use App\Entity\Photo;
use App\Repository\FolderRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Photo1Type extends AbstractType
{
    private array $folderList;

    public function __construct(FolderRepository $repository, private TagTransformer $transformer )
    {
        $this->folderList = $repository->findAll();
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('tags', TextType::class)
            ->add('parentFolder', ChoiceType::class, [
                'choices' => $this->folderList,
                'choice_label' => function(Folder $folder){
                    return $folder->getName();
                    },
            ])
        ;
        $builder->get('tags')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
