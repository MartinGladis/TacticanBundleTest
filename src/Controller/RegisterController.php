<?php

namespace App\Controller;

use App\Command\RegisterUserCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    public function __construct(
        private CommandBus $commandBus
    ) {}

    #[Route('/api/v1/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        try {
            $content = json_decode($request->getContent(), true);
            $command = new RegisterUserCommand($content['email'], $content['password']);

            $this->commandBus->handle($command);

            $message = "User Created";
            $code = 200;
            
        } catch (\Throwable $e) {
            $code = 400;
            $message = $e->getMessage();
        }

        return $this->json([
            "message" => $message
        ], $code);
    }
}
