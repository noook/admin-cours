<?php

namespace App\Controller\Admin;

use App\Entity\Group;
use App\Entity\User;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class UserCrudController extends AbstractCrudController
{
    private GroupRepository $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {

        yield TextField::new('firstname');
        yield TextField::new('lastname');
        yield EmailField::new('email');
        yield TextField::new('password')
            ->onlyWhenCreating();
        yield ChoiceField::new('roles')
            ->setSortable(false)
            ->allowMultipleChoices()
            ->setRequired(false)
            ->renderAsBadges([User::ROLE_ADMIN => 'primary'])
            ->setChoices(['Admin' => User::ROLE_ADMIN]);

        yield AssociationField::new('groups')
            ->setLabel('Classes')
            ->setSortable(false)
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->formatValue(function (int $count, User $user) {
                return "</span>" . implode('&nbsp;', $user->getGroups()->map(function (Group $group) {
                    return sprintf('<span class="%s">%s</span>', 'badge badge-secondary', $group->getName());
                })->toArray());
            });
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
