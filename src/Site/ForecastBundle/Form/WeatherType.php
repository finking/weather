<?php

namespace Site\ForecastBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeatherType extends AbstractType
{
    protected $listHistory;
    protected $listFigure;

    public function __construct($listHistory = null, $listFigure = null)
    {
        $this->listHistory = $listHistory;
        $this->listFigure  = $listFigure;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('townId', 'text', array(
                    'required' => true,
                ))
            ->add('duration', 'choice', array(
                'choices'     => $this->listFigure,
                'empty_value' => 'Выберите количество дней',

                ))
            ->add('comment', 'textarea', array(
                    'required' => false
                ))
            ->add('history', 'choice', array(
                'required'      => false,
                'choices'       => $this->listHistory,
                'empty_value'   => 'Последние запрошенные города'
            ));
    }

    public function getName()
    {
        return 'weather';
    }
} 