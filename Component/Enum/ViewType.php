<?php

namespace Daemon\SimplifyBundle\Component\Enum;

use Daemon\SimplifyBundle\Component\Exception\RouteNotMatchingToViewTypeException;


abstract class  ViewType extends Enum {

    const CREATE = 'create';
    const UPDATE = 'update';
    const SHOW = 'show';
    const INDEX = 'index';
    const DELETE = 'delete';

}