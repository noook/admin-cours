<?php

namespace App\Validator;

use App\Entity\Course;
use App\Entity\Exercise;
use App\Repository\CourseRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

#[\Attribute]
class SlugValidValidator extends ConstraintValidator
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /** @var Exercise $exercise */
        $exercise = $this->context->getObject();
        $course = $exercise->getCourse();
        $slugs = $course->getExercises()->map(fn (Exercise $exercise) => $exercise->getSlug());

        if ($slugs->contains($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}