<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\StreamBuilder;

use Strictify\Goodies\Goodies\StreamBuilder\Model\AbstractStream;

class UpdateStream extends AbstractStream
{
    protected function getAction(): string
    {
        return 'update';
    }
}
