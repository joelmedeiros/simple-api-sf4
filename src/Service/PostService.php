<?php

namespace App\Service;

use App\Document\Post;
use App\Repository\PostRepository;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class PostService
{
    /** @var PostRepository  */
    private $postRepository;

    public function __construct(ManagerRegistry $dataManager)
    {
        $this->postRepository = $dataManager->getRepository(Post::class);
    }

    /**
     * @param array $filters
     * @return array
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function list(array $filters): array
    {
        return $this->postRepository->findByQuery($filters['query']);
    }

    public function get($id)
    {
        /** @var Post $post */
        if ($post = $this->postRepository->find($id)) {
            return $post->toArray();
        }

        throw new ResourceNotFoundException("Post not found");
    }
}
