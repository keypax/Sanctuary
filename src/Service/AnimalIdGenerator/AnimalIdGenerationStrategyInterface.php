<?php

namespace App\Service\AnimalIdGenerator;

interface AnimalIdGenerationStrategyInterface
{
    public function proposeNextId() : string;
    public function incrementId() : void;
}