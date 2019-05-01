<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\CategoryType;
use App\FormNormalizer\FormErrorSerializer;
use App\Provider\CategoryProvider;
use App\Service\CategoryService;
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
     * @param Request $request
     * @return Response
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
     * @Route("/api/category", name="get_all_category", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function getAllCategoryAction(Request $request): Response
    {
        $page = (int)$request->get('page') ?? 1;
        $limit = (int)$request->get('limit') ?? 10;
        $data = $this->categoryProvider->getAll($page, $limit);

        return new JsonResponse($data);
    }
}
