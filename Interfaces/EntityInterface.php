<?php

namespace Daemon\SimplifyBundle\Interfaces;

interface EntityInterface {

    public function getId();

    public function getType();

    public function setCreatedAt(\DateTime $createdAt);

    public function getCreatedAt();

    public function setUpdatedAt(\DateTime $updatedAt);

    public function getUpdatedAt();

    public function toString();
}