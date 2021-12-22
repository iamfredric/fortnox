<?php

namespace Iamfredric\Fortnox\Resources;

class Invoice extends Resource
{
    protected function getIdKey(): string
    {
        return 'DocumentNumber';
    }
}
