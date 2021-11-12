<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Entity\Exercise;
use App\Entity\Group;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Cours');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Classes', 'fas fa-graduation-cap', Group::class)
            ->setPermission(User::ROLE_ADMIN);
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class)
            ->setPermission(User::ROLE_ADMIN);
        yield MenuItem::linkToCrud('Courses', 'fas fa-book', Course::class)
            ->setPermission(User::ROLE_ADMIN);
        yield MenuItem::linkToCrud('Exercises', 'fas fa-dumbbell', Exercise::class)
            ->setPermission(User::ROLE_ADMIN);
    }
}
