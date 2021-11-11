<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;

class ScaffoldPhpTesting extends StepAlways
{
    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Setting up PHP test helpers.',
            'PHP Testing scaffolding'
        );

        $this->createEscTestCaseFile();

        $feedback->feedback('✅ Testing helpers added.');

        return $next($feedback);
    }

    private function createEscTestCaseFile()
    {
        $this->updateFile(
            base_path('tests/TestCase.php'),
            'use CreatesApplication;',
            file_get_contents(__DIR__ . '/../stubs/TestCaseUtilityMethods.stub')
        );
    }
}
