<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class UserCrudController extends AbstractCrudController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname'),
            TextField::new('lastname'),
            EmailField::new('email'),
            TextField::new('password')
                ->onlyWhenCreating(),
            ChoiceField::new('roles')
                ->setSortable(false)
                ->allowMultipleChoices()
                ->setRequired(false)
                ->renderAsBadges([User::ROLE_ADMIN => 'primary'])
                ->setChoices(['Admin' => User::ROLE_ADMIN])
        ];
    }

    /**
     * @param $user User
     */
    public function persistEntity(EntityManagerInterface $entityManager, $user): void
    {
        $encodedPassword = $this->encodePassword($user, $user->getPassword());
        $user->setPassword($encodedPassword);

        parent::persistEntity($entityManager, $user);
    }

    private function encodePassword(User $user, string $password): string
    {
        $passwordEncoderFactory = new EncoderFactory([
            User::class => new MessageDigestPasswordEncoder('sha512', true, 5000)
        ]);

        $encoder = $passwordEncoderFactory->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }
}
