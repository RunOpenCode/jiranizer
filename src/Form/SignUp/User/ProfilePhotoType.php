<?php

namespace AppBundle\Form\SignUp\User;

use AppBundle\Entity\User\Photo;
use AppBundle\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Form type for profile photo.
 */
class ProfilePhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', VichImageType::class, [
                'required'       => false,
                'allow_delete'   => false,
                'download_link'  => false,
                'label'          => false,
                'image_uri'      => false,
                'attr'          => [
                    'accept' => $options['accept'],
                ],
                'error_bubbling' => true
            ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        /**
         * @var User $user
         */
        $user = $form->getParent()->getData();

        $view->vars['placeholder'] = $options['placeholder'];
        $view->vars['user']      = $user;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class'  => Photo::class,
                'placeholder' => null,
                'accept'      => 'image/jpeg,image/png,image/gif',
                'compound'    => true,
                'error_bubbling' => false
            ]);
    }

    public function getBlockPrefix()
    {
        return 'jiranizer_profile_photo';
    }
}
