<?php

namespace App\Service\AnimalIdProvider;

interface NextAnimalIdProviderInterface
{
    public function getNextId() : string;
    public function incrementId() : void;
}