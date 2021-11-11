<?php

namespace LV\ShopifyAppScaffolder\Commands;

use LV\BaseCommand\StepAlways;
use Symfony\Component\Process\Process;

class FixProjectPermissions extends StepAlways
{
    private $user;
    private $workingDirectory;

    public function handle($feedback, $next)
    {
        $feedback->feedback(
            'Attempting to fix your app file and folder permissions',
            'File and folder permissions.'
        );

        $process = new Process(['whoami']);
        $process->run();
        $this->user = trim($process->getOutput());
        if (!$process->isSuccessful()) {
            $feedback->advance('❌ Could not determine your OS username for setting app file and folder owning permissions.');
            return $next($feedback);
        }

        $process = new Process(['pwd']);
        $process->run();
        $this->workingDirectory = trim($process->getOutput());
        if (!$process->isSuccessful()) {
            $feedback->advance('❌ Could not determine your working directory for setting app file and folder owning permissions.');
            return $next($feedback);
        }

        $questionFormat = 'Would you like to set the owner of %s to %s:%s ?';
        $formattedQuestion = vsprintf($questionFormat, [$this->workingDirectory, $this->user, 'www-data']);
        $ask = $this->ask($formattedQuestion, false);

        if (strtolower($ask) !== 'yes') {
            $feedback->advance('🙈 Okay, I will leave your permissions as they are.');
            return $next($feedback);
        }

        $process = new Process([
            'chown',
            '-R',
            $this->user . ':www-data',
            $this->workingDirectory,
        ]);
        $process->run();
        if (!$process->isSuccessful()) {
            $feedback->advance('❌ Failed to change the owning permissions for ' . $this->workingDirectory);
            return $next($feedback);
        }

        $process = new Process([
            'chmod',
            '-R',
            '775',
            $this->workingDirectory . '/storage',
        ]);
        $process->run();
        if (!$process->isSuccessful()) {
            $feedback->advance('❌ Failed to change the owning permissions for ' . $this->workingDirectory);
            return $next($feedback);
        }

        $feedbackFormat = vsprintf(
            '✅ Folder permissions for %s updated to %s:%s',
            [$this->workingDirectory, $this->user, 'www-data']
        );

        $feedback->advance($feedbackFormat);

        return $next($feedback);
    }
}
