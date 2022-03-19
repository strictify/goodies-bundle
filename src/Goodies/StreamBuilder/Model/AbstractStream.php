<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\StreamBuilder\Model;

use LogicException;
use function ltrim;

abstract class AbstractStream implements StreamInterface
{
    public function __construct(
        private string  $targetId,
        private ?string $html = null,
    )
    {
    }

    public function __toString(): string
    {
        return $this->generate();
    }

    public function generate(): string
    {
        $action = $this->getAction();
        $targetId = ltrim($this->getTargetId(), '#');
        $html = (string)$this->getHtml();

        return <<<HTML
<turbo-stream action="$action" target="$targetId">
    <template>
        $html
    </template>
</turbo-stream>
HTML;
    }

    public function getTargetId(): string
    {
        return $this->targetId;
    }

    /**
     * @return 'update'|'replace'|'remove'|'append'|'prepend'|'before'|'after'
     */
    protected function getAction(): string
    {
        throw new LogicException();
    }

    protected function getHtml(): ?string
    {
        return $this->html;
    }
}
