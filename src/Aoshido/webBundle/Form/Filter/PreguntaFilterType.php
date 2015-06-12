<?php

namespace Aoshido\webBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PreguntaFilterType extends AbstractType {
/*
 * https://github.com/lexik/LexikFormFilterBundle/issues/40
 */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('Tema', 'filter_entity', array(
            'class' => 'AoshidowebBundle:Tema',
            'expanded' => false,
            'multiple' => true,
            'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                $query = $filterQuery->getQueryBuilder();
                $query->leftJoin($field, 'm');
                // Filter results using orWhere matching ID
                foreach ($values['value'] as $value) {
                    $query->orWhere($query->expr()->in('m.id', $value->getId()));
                }
            },
        ));

    }

    public function getName() {
        return 'pregunta_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }

}
