<?php

namespace Notify\Notyf\Renderer;

use Notify\Config\ConfigInterface;
use Notify\Envelope\Envelope;
use Notify\Renderer\HasGlobalOptionsInterface;
use Notify\Renderer\HasScriptsInterface;
use Notify\Renderer\HasStylesInterface;
use Notify\Renderer\RendererInterface;

class NotyfRenderer implements RendererInterface, HasScriptsInterface, HasStylesInterface, HasGlobalOptionsInterface
{
    /**
     * @var \Notify\Config\ConfigInterface
     */
    private $config;

    /**
     * @var array
     */
    private $scripts;

    /**
     * @var array
     */
    private $styles;

    /**
     * @var array
     */
    private $options;

    public function __construct(ConfigInterface $config)
    {
        $this->config  = $config;
        $this->scripts = $config->get('adapters.notyf.scripts', array());
        $this->styles  = $config->get('adapters.notyf.styles', array());
        $this->options = $config->get('adapters.notyf.options', array());
    }

    /**
     * @inheritDoc
     */
    public function render(Envelope $envelope)
    {
        $context = $envelope->getContext();
        $options = isset($context['options']) ? $context['options'] : array();

//        $options['message'] = $envelope->getTitle();
        $options['message'] = $envelope->getMessage();
        $options['type'] = $envelope->getType();



        return sprintf("notyf.open(%s);", json_encode($options));
    }

    /**
     * @inheritDoc
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * @inheritDoc
     */
    public function getStyles()
    {
        return $this->styles;
    }

    public function renderOptions()
    {
        return sprintf('if ("undefined" === typeof notyf) { var notyf = new Notyf(%s); }', json_encode($this->options));
    }
}
