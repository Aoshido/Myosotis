<?php

namespace Aoshido\webBundle\Admin\blocks;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;

class LastQuestionsBlock extends BaseBlockService {

    protected $em;
    protected $templating;
    protected $type;

    public function __construct($type, $templating, $em) {
        $this->type = $type;
        $this->templating = $templating;
        $this->em = $em;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'template' => 'AoshidowebBundle:Block:LastQuestionsBlock.html.twig',
        ));
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block) {
        
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {
        
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null) {
        // merge settings
        $settings = $blockContext->getSettings();

        $preguntas = $this->em->getRepository('AoshidowebBundle:Pregunta')->findBy(array(
            'activo' => TRUE
        ));
        
        return $this->renderResponse('AoshidowebBundle:Block:LastQuestionsBlock.html.twig', array(
                    'preguntas' => $preguntas,
                    'block' => $blockContext->getBlock(),
                    'settings' => $settings
                        ), $response);
    }

}
