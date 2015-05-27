<?php

namespace Daemon\SimplifyBundle\Component;


use Daemon\SimplifyBundle\Component\Enum\HTTP;

class FormOptions {

    private $route = null;

    private $method = HTTP::GET;

    private $defaultOptions = array();

    private $routeParameters = array();

    public function __construct($route = null) {
        $this->route = $route;
    }

    public function setRoute($route) {
        $this->route = $route;

        return $this;
    }

    public function getRoute() {
        return $this->route;
    }

    public function setMethod($method = HTTP::GET) {
        $this->method = $method;

        return $this;
    }

    public function getMethod() {
        return $this->method;
    }


    public function addDefaultOption($parameterId, $value) {
        $this->defaultOptions[$parameterId] = $value;

        return $this;
    }

    public function removeDefaultOption($parameterId) {
        unset($this->defaultOptions[$parameterId]);

        return $this;
    }

    public function clearDefaultOptions() {
        $this->defaultOptions =  array();
    }

    public function getDefaultOptions() {
        return $this->defaultOptions;
    }


    public function addRouteParameter($parameterId, $value) {
        $this->routeParameters[$parameterId] = $value;

        return $this;
    }

    public function removeRouteParameter($parameterId) {
        unset($this->routeParameters[$parameterId]);

        return $this;
    }

    public function clearRouteParameters() {
        $this->routeParameters =  array();
    }

    public function getRouteParameters() {
        return $this->routeParameters;
    }
}