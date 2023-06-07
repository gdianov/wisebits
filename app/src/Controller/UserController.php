<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/api', name: 'api_')]
class UserController extends AbstractFOSRestController
{
    /**
     * @var UserService
     */
    private UserService $service;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @param UserService $service
     * @param SerializerInterface $serializer
     */
    public function __construct(UserService $service, SerializerInterface $serializer)
    {
        $this->service = $service;
        $this->serializer = $serializer;
    }

    #[Route('/users/{id}', name: 'users_show', methods:['get'] )]
    public function get(int $id): Response
    {
        $user = $this->service->find($id);

        if ($user === null) {
            return $this->json('No user found for id ' . $id, Response::HTTP_NOT_FOUND);
        }

        return new Response($this->serializer->serialize($user, 'json'));
    }

    #[Route('/users', name: 'users_create', methods:['post'] )]
    #[ParamConverter("user", class: User::class, converter: "fos_rest.request_body")]
    public function create(User $user, ValidatorInterface $validator): Response
    {
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return $this->json(
                $this->getWrappedErrors($errors),
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->service->save($user);

        return new Response($this->serializer->serialize($user, 'json'), Response::HTTP_CREATED);
    }

    #[Route('/users/{id}', name: 'users_update', methods:['put'] )]
    #[ParamConverter("user", class: User::class, converter: "fos_rest.request_body")]
    public function update(User $user, int $id, ValidatorInterface $validator): Response
    {
        $userEntity = $this->service->find($id);

        if ($userEntity === null) {
            return $this->json('No user found for id ' . $id, Response::HTTP_NOT_FOUND);
        }

        $userEntity->setName($user->getName());
        $userEntity->setEmail($user->getEmail());
        $userEntity->setCreated($user->getCreated());
        $userEntity->setDeleted($user->getDeleted());
        $userEntity->setNotes($user->getNotes());

        $errors = $validator->validate($userEntity);

        if (count($errors) > 0) {
            return $this->json(
                $this->getWrappedErrors($errors),
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->service->save($userEntity);

        return new Response($this->serializer->serialize($user, 'json'));
    }

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     * @return array
     */
    private function getWrappedErrors(ConstraintViolationListInterface $constraintViolationList): array
    {
        $errors = [];
        foreach ($constraintViolationList as $item) {
            $errors[] = [
                'field' => $item->getPropertyPath(),
                'code' => $item->getCode(),
                'message' => $item->getMessage(),
            ];
        }

        return $errors;
    }
}
