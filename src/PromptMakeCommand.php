<?php

namespace SabatinoMasala\LaravelLlmPrompt;

use Illuminate\Console\Command;

class PromptMakeCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:prompt {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new prompt class';

    public function handle()
    {
        $name = $this->argument('name');
        if (!is_dir(app_path('Prompts'))) {
            mkdir(app_path('Prompts'));
        }
        $path = app_path('Prompts/' . $name . '.php');
        $stub = file_get_contents(__DIR__ . '/stubs/prompt.stub');
        $stub = str_replace('{{name}}', $name, $stub);
        file_put_contents($path, $stub);
    }

}
