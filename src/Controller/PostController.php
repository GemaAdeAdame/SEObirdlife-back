<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post', methods: ['POST', 'GET'])]
    public function likeBird(Request $request, EntityManagerInterface $entityManager, PostRepository $postRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        //Verificar si los datos enviados son válidos
        if (!isset($data) || !is_array($data) || count($data) === 0) {
            return $this->json(['error' => 'Datos inválidos'], $status = 400, $headers = ['Access-Control-Allow-Origin'=>'*']);
        }
// Recorrer la lista de pájaros
        
        foreach ($data['birds'] as $birdData) {
            $name = $birdData['name'];
            $bird = new Post();
            $bird->setName($name);
            $entityManager->persist($bird);
        }
        $bird = new Post();
        $bird->setName('');

        $entityManager->persist($bird);
        $entityManager->flush();

        // Obtener todos los datos actualizados

        $post = [];

        $result = $postRepository->findAll();
        foreach ($result as $r) {
            $post[] = [
                'id' => $r->getId(),
                'name' => $r->getName(),
            ];
        }

        return $this->json($post, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }
    #[Route('/allbird', name: 'app_allbird', methods: ['POST', 'GET'])]
    public function AllBird(Request $request, EntityManagerInterface $entityManager, PostRepository $postRepository): Response
    {
    $post = [];

    $result = $postRepository->findAll();
    foreach ($result as $r) {
        $post[] = [
            'id' => $r->getId(),
            'name' => $r->getName(),
        ];
    }
    return $this->json($post, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
}
}