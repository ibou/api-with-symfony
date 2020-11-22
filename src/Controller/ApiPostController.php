<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index", methods={"GET"})
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository)
    {
        return $this->json(
            $postRepository->findAll(),
            Response::HTTP_OK,
            [],
            [
                "groups" => "post:read",
            ]
        );
    }

    /**
     * @Route("/api/post", name="api_post_store", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function store(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    )
    {
        $jsonRecu = $request->getContent();
        try {
            /** @var Post $post */
            $post = $serializer->deserialize($jsonRecu, Post::class, 'json');
            $post->setCreatedAt(new \DateTime());
            $errors = $validator->validate($post);
            if(count($errors) > 0){
                return $this->json($errors, Response::HTTP_BAD_REQUEST);
            }
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->json(
                $post,
                Response::HTTP_CREATED,
                [],
                [
                    "groups" => "post:read",
                ]
            );
        } catch (NotEncodableValueException $ex) {
            return $this->json(
                [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => $ex->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
