<?php

/**
 * Created by PhpStorm.
 * User: kaduppg
 * Date: 12/9/18
 * Time: 2:45 PM
 */
namespace App\Form;


use App\Entity\MicroPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MicroPostType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', TextareaType::class , array('label'=> false))
                ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults(['data_class' => MicroPost::class]);
    }

}