<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Form;

use App\Domain\Category\Repository\CategoryRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CategoryType extends AbstractType
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotNull(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'constraints' => [
                new Callback([
                    'callback' => [$this, 'checkName'],
                ]),
            ],
        ]);
    }

    public function checkName(array $data, ExecutionContextInterface $context): void
    {
        $category = $this->categoryRepository->findOneByName($data['name']);

        if (null !== $category) {
            $context->addViolation('Name Exist.');
        }
    }
}
