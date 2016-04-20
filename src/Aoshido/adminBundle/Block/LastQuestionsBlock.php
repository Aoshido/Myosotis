<?php

namespace Sonata\BlockBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;

class LastQuestionBlock extends BaseBlockService {

    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'url' => false,
            'title' => 'Insert the rss title',
            'template' => 'SonataBlockBundle:Block:block_core_rss.html.twig',
        ));
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block) {
        $formMapper
                ->add('settings', 'sonata_type_immutable_array', array(
                    'keys' => array(
                        array('url', 'url', array('required' => false)),
                        array('title', 'text', array('required' => false)),
                    )
                ))
        ;
    }

    /**
     * @param ErrorElement   $errorElement
     * @param BlockInterface $block
     *
     * @return void
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {

        $errorElement
                ->with('settings.url')
                ->assertNotNull(array())
                ->assertNotBlank()
                ->end()
                ->with('settings.title')
                ->assertNotNull(array())
                ->assertNotBlank()
                ->assertMaxLength(array('limit' => 50))
                ->end()
        ;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null) {
        // merge settings
        $settings = $blockContext->getSettings();
        $feeds = false;

        if ($settings['url']) {
            $options = array(
                'http' => array(
                    'user_agent' => 'Sonata/RSS Reader',
                    'timeout' => 2,
                )
            );

            // retrieve contents with a specific stream context to avoid php errors
            $content = @file_get_contents($settings['url'], false, stream_context_create($options));

            if ($content) {
                // generate a simple xml element
                try {
                    $feeds = new \SimpleXMLElement($content);
                    $feeds = $feeds->channel->item;
                } catch (\Exception $e) {
                    // silently fail error
                }
            }
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
                    'feeds' => $feeds,
                    'block' => $blockContext->getBlock(),
                    'settings' => $settings
                        ), $response);
    }

}
