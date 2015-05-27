<?php

namespace Daemon\SimplifyBundle\Component;

use Daemon\SimplifyBundle\Component\Enum\HTTP;

/**
 * Helper class to hold the options transmittable to the form
 *
 * Class FormOptions
 * @package Daemon\SimplifyBundle\Component
 */
class FormOptions {

    /**
     * The route to which the the form should submit
     * @var string
     */
    private $route = null;

    /**
     * The HTTP-method with which the request will be fired
     * @var string
     */
    private $method = HTTP::GET;

    /**
     * VariableBag which will be transmitted to the FormType-class
     * @var array
     */
    private $defaultOptions = array();

    /**
     * ParameterBag with all parameters (key => value | where the key is the variable name) required to build dynamic urls
     * @var array
     */
    private $routeParameters = array();

    /**
     * A custom form route can be inserted here
     * @param null $route
     */
    public function __construct($route = null) {
        $this->route = $route;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return $this
     */
    public function setRoute($route) {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return null|string
     */
    public function getRoute() {
        return $this->route;
    }

    /**
     * Set HTTP-method
     *
     * @param string $method
     * @return $this
     */
    public function setMethod($method = HTTP::GET) {
        $this->method = $method;

        return $this;
    }

    /**
     * Get HTTP-method
     *
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }


    /**
     * Add a variable to the bag so it will be processed to the FormType
     *
     * @param $parameterId
     * @param $value
     * @return $this
     */
    public function addDefaultOption($parameterId, $value) {
        $this->defaultOptions[$parameterId] = $value;

        return $this;
    }

    /**
     * Remove a variable from the bag
     *
     * @param $parameterId
     * @return $this
     */
    public function removeDefaultOption($parameterId) {
        unset($this->defaultOptions[$parameterId]);

        return $this;
    }

    /**
     * Clear the bag
     */
    public function clearDefaultOptions() {
        $this->defaultOptions =  array();
    }

    /**
     * Get the bag of values to be processed to the FormType
     *
     * @return array
     */
    public function getDefaultOptions() {
        return $this->defaultOptions;
    }

    /**
     * Add a parameter for the url-builder
     *
     * @param $parameterId
     * @param $value
     * @return $this
     */
    public function addRouteParameter($parameterId, $value) {
        $this->routeParameters[$parameterId] = $value;

        return $this;
    }

    /**
     * Remove a parameter
     *
     * @param $parameterId
     * @return $this
     */
    public function removeRouteParameter($parameterId) {
        unset($this->routeParameters[$parameterId]);

        return $this;
    }

    /**
     * Clear all parameters
     */
    public function clearRouteParameters() {
        $this->routeParameters =  array();
    }

    /**
     * Get all parameters used for building  the url
     *
     * @return array
     */
    public function getRouteParameters() {
        return $this->routeParameters;
    }
}