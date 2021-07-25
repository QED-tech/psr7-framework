<?php

namespace Framework\Http\Pipelines;

class MiddlewareResolver
{
    public function resolve(mixed $handlers): callable
    {
        $pipeline = new Pipeline();
        $handlers = is_array($handlers) ? $handlers : [$handlers];

        foreach ($handlers as $handler) {
            $pipeline->pipe($this->preResolve($handler));
        }

        return $pipeline;
    }

    private function preResolve(mixed $handler): callable
    {
        return is_string($handler) ? new $handler() : $handler;
    }
}
