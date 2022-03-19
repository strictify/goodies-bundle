<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\StreamBuilder;

use Strictify\Goodies\Goodies\StreamBuilder\Model\AbstractStream;

class ReloadStream extends AbstractStream
{
    protected function getHtml(): ?string
    {
        $id = $this->getTargetId();

        return <<<HTML
        <meta data-controller="reload" data-reload-id-value="$id" >
HTML;
    }


    protected function getAction(): string
    {
        return 'update';
    }
}
