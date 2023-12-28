<?php

namespace App\Controller\API;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class
APIController extends AbstractController
{
    public static function validateAndPersist(mixed                  $value,
                                              ValidatorInterface     $validator,
                                              EntityManagerInterface $entityManager): Response
    {
        $errors = $validator->validate($value);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($value);
        $entityManager->flush();
        return new JsonResponse($value->toArray());
    }

    public static function validateAndPersistUser(User                        $user,
                                                  ValidatorInterface          $validator,
                                                  EntityManagerInterface      $entityManager,
                                                  UserPasswordHasherInterface $hasher): Response
    {
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        if ($user->getId() && !$hasher->isPasswordValid($user, $user->getPlainPassword())) {
            return new JsonResponse(['message' => 'Password is incorrect'], Response::HTTP_UNAUTHORIZED);
        }

        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse($user->toArray());
    }
}
