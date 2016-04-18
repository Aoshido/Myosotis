<?php

namespace Aoshido\adminBundle\Block;

use Sonata\BlockBundle\Block\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;

use Sonata\BlockBundle\Block\BlockServiceInterface;

class LastQuestionsBlock implements BlockServiceInterface {

    public function getName() {
        return 'My Newsletter';
    }

    public function getDefaultSettings() {
        return array();
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {
        
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block) {
        
    }

    public function execute(BlockInterface $block, Response $response = null) {
        // merge settings
        $settings = array_merge($this->getDefaultSettings(), $block->getSettings());

        return $this->renderResponse('InstitutoStoricoNewsletterBundle:Block:block_my_newsletter.html.twig', array(
                    'block' => $block,
                    'settings' => $settings
                        ), $response);
    }

}
