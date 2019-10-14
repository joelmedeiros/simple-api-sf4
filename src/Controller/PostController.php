<?php

namespace App\Controller;

use App\Service\PostService;
use FOS\RestBundle\Controller\{AbstractFOSRestController, Annotations as Rest};
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractFOSRestController
{
    /** @var PostService  */
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @Rest\QueryParam(name="query")
     * @Rest\Route("", name="api_post_list", methods={"GET"})
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request): array
    {

        $filters['query'] = $request->query->get('q', null);

        return [
            'success' => true,
            'data' => $this->postService->list($filters)
        ];
    }

    /**
     * @Rest\Route("{id}", name="api_post_detail", methods={"GET"})
     *
     * @param string $id
     * @return array
     */
    public function detailAction($id): array
    {
        return [
            'success' => true,
            'data' => $this->postService->get($id)
        ];
    }
}
