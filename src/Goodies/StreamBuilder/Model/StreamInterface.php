<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\StreamBuilder\Model;

interface StreamInterface
{
    public function generate(): string;
}
