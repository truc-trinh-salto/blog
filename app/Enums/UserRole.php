<?php

namespace App\Enums;

enum UserRole: string
{
   case Adminstrator = 'admin';
   case User = 'user';
}