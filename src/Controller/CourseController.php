<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Group;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('/courses', name: 'courses')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $classes = $user->getGroups();
        $courses = [];

        foreach ($classes as $class) {
            $courses[$class->getName()] = [];

            foreach ($class->getCourses() as $course) {
                $courses[$class->getName()][] = $course;
            }
        }

        return $this->render('course/index.html.twig', [
            'classes' => $courses,
        ]);
    }

}
