<?php

namespace App\Controller\API;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class APIUserController extends AbstractController
{
    #[Route('/api/user', name: 'apiUserPOST', methods: ['POST'])]
    public function post(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        var_dump($data);

        if (isset($data['id'])) {
//            $user = $userRepository->find($data['id']);
        } else {
            $user = new User();
        }

        $user->updateIdentifier($data['email'], $data['plainPassword']);
        $user->updateIdentity($data['firstName'], $data['lastName']);
        $user->updateAddress($data['address'], $data['city'], $data['zipcode']);
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse($user->toArray());
    }
}
