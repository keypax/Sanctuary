<?php

namespace App\Service\History;

interface HistoryTrackedInterface
{
    public function getHistoryContext(): string;
}