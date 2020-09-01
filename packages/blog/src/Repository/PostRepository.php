<?php

declare(strict_types=1);

namespace Pehapkari\Blog\Repository;

use Pehapkari\Blog\ValueObject\Post;
use Pehapkari\Blog\ValueObjectFactory\PostFactory;
use Pehapkari\Exception\PostNotFoundException;
use Symfony\Component\Finder\Finder;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\SmartFileInfo;

final class PostRepository
{
    /**
     * @var string
     */
    private const POST_DIRECTORY = __DIR__ . '/../../data';

    private FinderSanitizer $finderSanitizer;

    /**
     * @var Post[]
     */
    private array $posts = [];

    public function __construct(PostFactory $postFactory, FinderSanitizer $finderSanitizer)
    {
        $this->finderSanitizer = $finderSanitizer;
        $this->initPosts($postFactory);
    }

    /**
     * @throws PostNotFoundException
     */
    public function getBySlug(string $slug): Post
    {
        foreach ($this->posts as $post) {
            if ($post->getSlug() === $slug) {
                return $post;
            }
        }

        throw new PostNotFoundException($slug);
    }

    /**
     * @return Post[]
     */
    public function fetchAll(): array
    {
        return $this->posts;
    }

    /**
     * @return string[]
     */
    public function getAllSlugs(): array
    {
        $slugs = [];

        foreach ($this->posts as $post) {
            $slugs[] = $post->getSlug();
        }

        return $slugs;
    }

    private function initPosts(PostFactory $postFactory): void
    {
        foreach ($this->findPostMarkdownFileInfos() as $smartFileInfo) {
            $post = $postFactory->createFromFileInfo($smartFileInfo);
            $this->posts[$post->getId()] = $post;
        }

        // sort posts from newest one
        usort($this->posts, function (Post $firstPost, Post $secondPost) {
            return $secondPost->getDateTime() <=> $firstPost->getDateTime();
        });
    }

    /**
     * @return SmartFileInfo[]
     */
    private function findPostMarkdownFileInfos(): array
    {
        $finder = new Finder();
        $finder->files()
            ->in(self:: POST_DIRECTORY)
            ->name('*.md');

        return $this->finderSanitizer->sanitize($finder);
    }
}
