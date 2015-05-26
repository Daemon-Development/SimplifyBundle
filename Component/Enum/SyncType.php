<?php

namespace Daemon\SimplifyBundle\Component\Enum;

abstract class SyncType extends Enum {

    const CREATE = 'create';
    const UPDATE = 'update';
    const DELETE = 'delete';
}