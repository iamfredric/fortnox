<?php

namespace Iamfredric\Fortnox\Resources;

class Customer extends Resource
{
    protected function getIdKey(): string
    {
        return 'CustomerNumber';
    }
}
