<?php

namespace AppBundle\Form\Jira;

use AppBundle\Entity\User\Jira;
use AppBundle\Enum\User\JiraStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JiraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('url', UrlType::class)
            ->add('username', TextType::class)
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'jira.form.field.password',
                        'class' => 'form-control')),
                'second_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'jira.form.field.passwordRepeat',
                        'class' => 'form-control')),
                'translation_domain' => 'user',
            ))
        ;

        $builder->addEventListener(FormEvents::SUBMIT, \Closure::bind(function (FormEvent $event) {
            $this->onFormSubmit($event);
        }, $this));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jira::class,
        ]);
    }

    private function onFormSubmit(FormEvent $event)
    {
        /** @var Jira $jira */
        $jira = $event->getData();

        $jira->setStatus(JiraStatus::ENABLED);
    }
}
