<?php

namespace Daemon\SimplifyBundle\Component\Enum;

abstract class  ViewContext extends Enum {

    const INDEX = 'INDEX';
    const CREATE = 'CREATE';
    const UPDATE = 'UPDATE';
    const SHOW = 'SHOW';
    const DELETE = 'DELETE';

}