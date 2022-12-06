<?php

namespace App\Controller;

use App\Command\RegisterUserCommand;
use League\Tactician\Bundle\Middleware\InvalidCommandException;
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
            $command = RegisterUserCommand::fromRequest($request);

            $this->commandBus->handle($command);

            $code = 200;
            $message = "User Created";
        } catch (InvalidCommandException $e) {
            $code = 400;
            $message = $e->getViolations()->get(0)->getMessage();
        } catch (\Throwable $e) {
            $code = 400;
            $message = $e->getMessage();
        }

        return $this->json([
            "message" => $message
        ], $code);
    }
}
