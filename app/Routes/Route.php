<?php

namespace App\Routes;

use Laravel\Lumen\Routing\Router;

class Route
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function get(string $url): Router
    {
        return $this->router->get($url, [
            'as' => $url,
            'uses' => $this->computeControllerMethod($url),
        ]);
    }

    public function post(string $url): Router
    {
        return $this->router->post($url, [
            'as' => $url,
            'uses' => $this->computeControllerMethod($url),
        ]);
    }

    /**
     * Compute a controller method name using $url.
     *
     * Example: $url = 'certificate.get' ->
     * -> certificate -> 'Certificate' + 'Controller' -> 'CertificateController' ->
     * -> 'CertificateController' + '.' + 'get' ->
     * -> 'CertificateController.get'
     *
     * @param string $url
     * @return null|string
     */
    private function computeControllerMethod(string $url): ?string
    {
        $controllerMethod = null;

        $sectors = explode(".", $url);
        $controller = array_shift($sectors);
        $method = array_pop($sectors);

        if (count($sectors)) {
            $method = $this->computeComplicatedMethodName($sectors, $method);
        }

        if ($controller && $method) {
            $controller = ucfirst($controller);
            $controllerMethod = "${controller}Controller@${method}";
        }

        return $controllerMethod;
    }

    /**
     * Compute complicated method name.
     *
     * Example: user.profile.settings.update
     * $sectors = ['profile', 'settings'];
     * $methodPrefix = 'update';
     * -> updateProfileSettings
     *
     * @param array $sectors
     * @param string $methodPrefix
     * @return string
     */
    private function computeComplicatedMethodName(array $sectors, string $methodPrefix): string
    {
        $sectors = array_map(function (string $sector) {
            return ucfirst($sector);
        }, $sectors);

        $methodPostfix = implode($sectors);

        return "${methodPrefix}${methodPostfix}";
    }
}
