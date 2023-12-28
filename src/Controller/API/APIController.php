<?php

namespace App\Controller\API;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class
APIController extends AbstractController
{
    public static function validateAndPersist(mixed $value, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
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
}
