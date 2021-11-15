<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class SlugValid extends Constraint
{
    public $message = 'The slug "{{ string }}" is not unique within this course';
}