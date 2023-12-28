<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class APIUserController extends AbstractController
{
    #[Route('/api/user', name: 'apiUserPOST', methods: ['POST'])]
    public function post(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager,
                         UserRepository $repository, UserPasswordHasherInterface $hasher): Response
    {
        $data = json_decode($request->getContent(), true);
        var_dump($data);

        if (isset($data['id'])) {
            $user = $repository->find($data['id']);
        } else {
            $user = new User();
        }

        $user->updateIdentifier($data['email'], $data['plainPassword']);
        $user->updateIdentity($data['firstName'], $data['lastName']);
        $user->updateAddress($data['address'], $data['city'], $data['zipcode']);
        return APIController::validateAndPersistUser($user, $validator, $entityManager, $hasher);
    }

    #[Route('/api/user/login', name: 'apiUserLogin', methods: ['POST'])]
    public function login(Request                     $request,
                          UserRepository              $repository,
                          UserPasswordHasherInterface $hasher,
                          TokenStorageInterface       $storage): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $repository->findOneBy(['email' => $data['email']]);
        if ($user && $hasher->isPasswordValid($user, $data['plainPassword'])) {
            $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
            $storage->setToken($token);
            return new JsonResponse($user->getFirstName(), Response::HTTP_OK);
        } else {
            return new JsonResponse('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }
    }
}
