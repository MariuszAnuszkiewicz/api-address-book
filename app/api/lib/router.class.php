<?php

declare(strict_types=1);

class Router {

    protected $action;
    protected $controller;
    protected $params;
    protected $uri;

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function __construct(string $uri)
    {
        $this->uri = urldecode(trim($uri, '/'));
        $this->controller = strtolower($this->getUrIParts()[0]);
        $this->action = $this->getApiMethods($_SERVER['REQUEST_METHOD'], $this->getParamsFromUrl());
    }

    public function getParamsFromUrl(): int
    {
        $uriParts = $this->getUrIParts();
        $length = count($uriParts);
        if ($length > 1) {
            $this->params = (int) $uriParts[$length -1];
        } else {
            $this->params = 0;
        }

        return $this->params;
    }

    public static function getApiMethods(string $requestMethods, int $id): string
    {
        $typeSwitch = 'index';

        if ($id > 0) {
            $typeSwitch = 'show';
        }

        $methods = match ($requestMethods) {
            'GET' => $typeSwitch,
            'POST' => 'store',
            'DELETE' => 'delete',
            'PUT' => 'edit',
            'PATCH' => 'edit',
            default => $typeSwitch
        };

        return $methods;
    }

    public static function redirect(string $location)
    {
        header("Location: $location");
        exit;
    }

    public function guardParams()
    {
        $uriParts = $this->getUrIParts();
        $length = count($uriParts);
        if ($length > 2) {
           self::redirect('/api/user');
        }
    }

    /*
     * Urls
     *
     * api/user
     * api/user/{id}
     *
     */
    public function initRoute()
    {
        $this->guardParams();
        $id = $this->getParamsFromUrl();

        $user = '/user';

        if ($id > 0) {
            $user = '/user/' . $id;
        }

        Config::set('routes', [
            'default' => 'api',
            'user' => $user,
        ]);
    }

    public function getUrIParts(): array
    {
        return $uriParts = explode('/', $this->uri);
    }
}





