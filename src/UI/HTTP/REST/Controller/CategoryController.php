<?php

declare(strict_types=1);

namespace App\UI\HTTP\REST\Controller;

use App\Application\Provider\CategoryProvider;
use App\Application\Service\CategoryService;
use App\Infrastructure\Shared\FormNormalizer\FormErrorSerializer;
use App\UI\HTTP\Form\CategoryType;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CategoryController extends AbstractController
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @var CategoryProvider
     */
    private $categoryProvider;

    /**
     * @var FormErrorSerializer
     */
    private $errorSerializer;

    public function __construct(CategoryService $categoryService, CategoryProvider $categoryProvider, FormErrorSerializer $errorSerializer)
    {
        $this->categoryService = $categoryService;
        $this->categoryProvider = $categoryProvider;
        $this->errorSerializer = $errorSerializer;
    }

    /**
     * @Route("/api/category", name="create_category", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createAction(Request $request): Response
    {
        /** @var string $json */
        $json = $request->getContent();
        $data = \json_decode($json, true);
        $form = $this->createForm(CategoryType::class);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->create((string) $data['name']);

            return new JsonResponse('ok');
        }

        return new JsonResponse($this->errorSerializer->convertFormToArray($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/api/category/{page}/{limit}", name="get_all_category", methods={"GET"}, requirements={"page"="\d+", "limit"="\d+"},defaults={"limit": "10","page": "1"})
     *
     * @param Request $request
     * @param int     $page
     * @param int     $limit
     *
     * @return Response
     */
    public function getAllCategoryAction(Request $request, int $page, int $limit): Response
    {
        $data = $this->categoryProvider->getAll($page, $limit);

        return new JsonResponse($data);
    }
}
