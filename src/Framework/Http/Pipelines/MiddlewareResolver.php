<?php

namespace Framework\Http\Pipelines;

class MiddlewareResolver
{
    public function resolve(mixed $handler): callable
    {
        if (is_array($handler)) {
            return $this->createPipe($handler);
        }

        if (is_string($handler)) {
            return $this->createHandler($handler);
        }

        return $handler;
    }

    private function createPipe(array $handlers): Pipeline
    {
        $pipeline = new Pipeline();
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->createHandler($handler));
        }
        return $pipeline;
    }

    private function createHandler(mixed $handler): callable
    {
        return is_string($handler) ? new $handler() : $handler;
    }
}
