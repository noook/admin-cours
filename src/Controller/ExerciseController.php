<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciseController extends AbstractController
{
    #[Route('/courses/{course}/{exercise}', name: 'exercise')]
    #[ParamConverter('course', options: ['mapping' => ['course' => 'slug']])]
    #[ParamConverter('exercise', options: ['mapping' => ['exercise' => 'slug']])]
    public function detail(Course $course, Exercise $exercise): Response
    {

        $environment = new Environment();
        $environment
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new HighlightCodeExtension('github-light'));

        $commonMarkConverter = new MarkdownConverter($environment);

        $exerciseContent = $commonMarkConverter->convertToHtml($exercise->getContent());

        return $this->render('exercise/detail.html.twig', [
            'course' => $course,
            'exercise' => $exercise,
            'content' => $exerciseContent,
        ]);
    }

    #[Route('/courses/{course}', name: 'course-exercises')]
    #[ParamConverter('course', options: ['mapping' => ['course' => 'slug']])]
    public function index(Course $course, ExerciseRepository $exerciseRepository): Response
    {
        return $this->render('exercise/index.html.twig', [
            'course' => $course,
            'exercises' => $exerciseRepository->findBy([], ['name' => 'ASC']),
        ]);
    }
}
