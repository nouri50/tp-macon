<?php
namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ServiceTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
    ->add('description')
    ->add('imageFile', FileType::class, [
        'label' => 'Image',
        'mapped' => true,
        'required' => false,
        'constraints' => [
            new File([
                'maxSize' => '4M',
                'mimeTypes' => ['image/jpeg', 'image/png'],
                'mimeTypesMessage' => 'Merci de téléverser une image JPG ou PNG.',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
