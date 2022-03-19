<?php

declare(strict_types=1);

namespace Strictify\Goodies\Goodies\StreamBuilder;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Exception\ExceptionInterface;
use Strictify\Goodies\Goodies\StreamBuilder\Model\StreamInterface;
use function implode;
use function sprintf;
use function array_map;

class StreamBuilder
{
    public function __construct(
        private HubInterface    $hub,
        private LoggerInterface $logger,
    )
    {
    }

    public function createResponse(StreamInterface ...$streams): Response
    {
        $merged = $this->merge(...$streams);

        $response = new Response($merged);
        $response->headers->set('Content-Type', 'text/vnd.turbo-stream.html');

        return $response;
    }

    public function pushToPublic(StreamInterface ...$streams): void
    {
        $this->push('public', ...$streams);
    }

    public function push(string $topic, StreamInterface ...$streams): void
    {
        $merged = $this->merge(...$streams);
        try {
            $update = new Update(
                $topic,
                $merged,
            );
            $this->hub->publish($update);
        } catch (ExceptionInterface $e) {
            // we don't want code interruption if hub failed
            $this->logger->alert(sprintf('Mercure hub failed with message: %s', $e->getMessage()));
        }
    }

    private function merge(StreamInterface ...$streams): string
    {
        $asArray = array_map(fn(StreamInterface $stream) => $stream->generate(), $streams);

        return implode("\n", $asArray);
    }
}
