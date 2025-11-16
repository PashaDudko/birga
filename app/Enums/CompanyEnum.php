<?php

namespace App\Enums;

enum CompanyEnum: string
{
    case CREATED = 'created';
    case UPDATED = 'updated';
    case DUPLICATE = 'duplicate';
}
