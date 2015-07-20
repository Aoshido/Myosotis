<?php

// ItemFilterType.php

namespace LanCl\SiteBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BusquedasOrdenesCompraFilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('nroOrdenRango', 'filter_number_range', array(
                    'left_number_options' => array(
                        'attr' => array('class' => 'number search-field-rango-orden'),
                        //'widget' => 'single_text',
                        'label' => 'Desde:',
                    ),
                    'right_number_options' => array(
                        'attr' => array('class' => 'number search-field-rango-orden'),
                        //'widget' => 'single_text',
                        'label' => 'Hasta:',
                    ),
                    'label' => 'Rango Ordenes',
                ))        
                ->add('idmoneda', 'filter_entity', array(
                    'label' => 'Moneda',
                    'class' => 'LanClSiteBundle:Monedas',
                    'property' => 'codigo',
                    'attr' => array('class' => 'search-field-moneda'),
                    'empty_value' => "- Seleccione -",
                    'query_builder' => function ( $repository) {
                return $repository->createQueryBuilder('a')->Where('a.activo=true');
            },
                ))
                ->add('fechaOrden', 'filter_date_range', array(
                    'left_date_options' => array(
                        'attr' => array('class' => 'date search-field-fecha-orden'),
                        'format' => 'dd/MM/yyyy',
                        'widget' => 'single_text',
                        'label' => 'Desde:',
                    ),
                    'right_date_options' => array(
                        'attr' => array('class' => 'date search-field-fecha-orden'),
                        'format' => 'dd/MM/yyyy',
                        'widget' => 'single_text',
                        'label' => 'Hasta:',
                    ),
                    'label' => 'Fecha Orden',
                ))
                ->add('OrdenEstado', 'filter_entity', array(
                    'label' => 'Estado',
                    'class' => 'LanClSiteBundle:OrdenesCompraEstados',
                    'property' => 'descripcion',
                    'attr' => array('class' => 'search-field-estado'),
                    'empty_value' => "- Seleccione -",
                    'expanded' => true,
                    'multiple'=>true,
                    'query_builder' => function ( $repository) {
                return $repository->createQueryBuilder('a')->Where('a.activo=true');
            },
                ))
                ->add('UsuarioComprador', 'filter_text', array(
                    'label' => 'Usuario',
                    'attr' => array('class' => 'search-field-UsuarioComprador'),
                ))
                ->add('UsuarioSuplente', 'filter_text', array(
                    'label' => 'Suplente',
                    'attr' => array('class' => 'search-field-UsuarioSuplente'),
                ))
                ->add('Proveedor', 'filter_text', array(
                    'label' => 'Proveedor',
                    'attr' => array('class' => 'search-field-Proveedor'),
                ))
                ->add('nroBp', 'filter_text', array(
                    'label' => 'Numero BP',
                    'attr' => array('class' => 'search-field-nroBp'),
                ))
                ->setMethod('GET');
    }

    public function getName() {
        return 'busquedas_ordenes_compra_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }

}
