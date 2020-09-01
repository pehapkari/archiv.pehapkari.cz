<?php

declare(strict_types=1);

namespace Pehapkari\Blog\Controller;

use Pehapkari\Blog\Repository\AuthorRepository;
use Pehapkari\Blog\Repository\PostRepository;
use Pehapkari\Blog\ValueObject\Post;
use Pehapkari\Exception\PostNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symplify\SymfonyStaticDumper\Contract\ControllerWithDataProviderInterface;

final class PostController extends AbstractController implements ControllerWithDataProviderInterface
{
    private AuthorRepository $authorsProvider;

    private PostRepository $postRepository;

    public function __construct(AuthorRepository $authorRepository, PostRepository $postRepository)
    {
        $this->authorsProvider = $authorRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @Route(path="blog/{postSlug}", name="post", requirements={"postSlug":".+[^\/]"})
     */
    public function __invoke(string $postSlug): Response
    {
        $post = $this->resolvePost($postSlug);

        return $this->render('blog/post.twig', [
            'post' => $post,
            'authors' => $this->authorsProvider->fetchAll(),
            'title' => $post->getTitle(),
        ]);
    }

    public function getControllerClass(): string
    {
        return self::class;
    }

    public function getControllerMethod(): string
    {
        return '__invoke';
    }

    /**
     * @return string[]
     */
    public function getArguments(): array
    {
        return $this->postRepository->getAllSlugs();
    }

    private function resolvePost(string $postSlug): Post
    {
        try {
            return $this->postRepository->getBySlug($postSlug);
        } catch (PostNotFoundException $postNotFoundException) {
            throw $this->createNotFoundException($postNotFoundException->getMessage(), $postNotFoundException);
        }
    }
}
