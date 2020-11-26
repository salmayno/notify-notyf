<?php

namespace Notify\Notyf\Producer;

use Notify\Producer\AbstractProducer;

final class NotyfProducer extends AbstractProducer
{
    /**
     * @inheritDoc
     */
    public function getRenderer()
    {
        return 'notyf';
    }
}
