<?php

namespace SabatinoMasala\LaravelLlmPrompt;

use Closure;
use Illuminate\Support\ServiceProvider;

class LlmPromptServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PromptMakeCommand::class,
            ]);
        }
    }
}