<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Student;
use App\Entity\StudentCourse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentCourseForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nberCourses')
            ->add('amount')
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => 'id',
            ])
            ->add('course', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentCourse::class,
        ]);
    }
}
