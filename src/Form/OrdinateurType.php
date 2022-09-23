<?php

namespace App\Form;

use App\Entity\Marques;
use App\Entity\Ordinateurs;
use App\Repository\MarquesRepository;
use App\Repository\OrdinateursRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdinateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('Ram')
            ->add('Processeur')
            ->add('carte_graphique')
            ->add('Poids')
            ->add('dimensions_ecran')
            ->add('type', ChoiceType::class, [
                'choices' => $this->getChoiceType()
            ])
            ->add('stockage')
            ->add('type_stockage', ChoiceType::class, [
                'choices' => $this->getChoiceStrorageType()
            ])
            ->add('caracteristique')
            ->add('port_usb');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ordinateurs::class,
        ]);
    }

    private function getChoiceType()
    {
        $choices = Ordinateurs::TYPE;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }

    private function getChoiceStrorageType()
    {
        $choices = Ordinateurs::TYPE_STOCKAGE;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
