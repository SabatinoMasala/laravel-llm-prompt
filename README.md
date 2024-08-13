# LLM helper classes for Laravel

This repository allows you to manage prompts for LLM's with ease.

## Installation

```
composer require sabatinomasala/laravel-llm-prompt
```

The package will be automatically discovered.

## Commands

The package allows you to create prompts using the following command:

```
php artisan make:prompt Example
```

The prompt will be added to the `app/Prompts/` directory.

## Usage

Working with large prompts can be a challenge, especially when dealing with many variables.
The Example prompt created above looks a little something like this:

```
<?php

namespace App\Prompts;

use SabatinoMasala\LaravelLlmPrompt\BasePrompt;

class Example extends BasePrompt
{

    public function __construct(
        public string $language = 'English'
    ) {}

    public function getBasePrompt(): string
    {
        // You can use variables in the prompt
        return 'Explain the pythagorean theorem in {language} as if I were a 5 year old.';
    }
}
```

Every **public** variable on the class is made available to the prompt to use and will be replaced when you get the prompt:

```
$prompt = new \App\Prompts\Example('French');
echo $prompt->get();
// Explain the pythagorean theorem in French as if I were a 5 year old.
```

You can dynamically add content to the prompt as follows:

```
<?php

namespace App\Prompts;

use SabatinoMasala\LaravelLlmPrompt\BasePrompt;

class Brainstorm extends BasePrompt
{

    public function __construct(
        public string $language,
        public string $series,
    ){}

    public function addHistory(array $history): void
    {
        $this->add('Make sure the following titles are not in the list:');
        collect($history)->each(function($line) {
            $this->add('- ' . $line);
        });
    }

    public function getBasePrompt(): string
    {
        return 'Give me a list of 30 story titles in {language} I can write.
Only respond with a list of titles, no other information.
1 title per line.
A good title consists of 4-8 words.
Do not number the list.
You will be penalized if the language is not {language}
The story should fit in the series {series}';
    }
}
```

```
$prompt = new \App\Prompts\Brainstorm('French', 'Roman empire');
$prompt->addHistory([
    'The downfall of Caesar',
    'Romulus & Remus: where it all started',
    'The tortoise formation',
]);
echo $prompt->get();
```
