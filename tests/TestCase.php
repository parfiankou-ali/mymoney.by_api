<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    abstract protected function versionPrefix(): string;

    protected function getVersionPrefix(): string
    {
        $versionPrefix = $this->versionPrefix();

        return "${versionPrefix}";
    }

    protected function url(string $url): string
    {
        $host = env('APP_URL', 'http://localhost');
        $versionPrefix = $this->getVersionPrefix();

        return "${host}/${versionPrefix}/$url";
    }
}
