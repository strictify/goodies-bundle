<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\StreamBuilder;

use Strictify\Goodies\Goodies\StreamBuilder\Model\AbstractStream;

class RemoveStream extends AbstractStream
{
    protected function getAction(): string
    {
        return 'remove';
    }
}
