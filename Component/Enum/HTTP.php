<?php

namespace Daemon\SimplifyBundle\Component\Enum;

abstract class HTTP extends Enum {

    const HEAD = "head";
    const GET = "get";
    const PUT = "put";
    const POST = "post";
    const DELETE = "delete";
    const TRACE = "trace";
}