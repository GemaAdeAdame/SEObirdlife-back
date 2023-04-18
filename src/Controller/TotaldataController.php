<?php

namespace App\Controller;



use App\Entity\Totaldata;
use App\Form\TotaldataType;
use App\Repository\TotaldataRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/totaldata')]
class TotaldataController extends AbstractController
{
    #[Route('/list', name: 'app_totaldata_index', methods: ['POST', 'GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager, TotaldataRepository $totaldataRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        //Verificar si los datos enviados son válidos
        if (!isset($data) || !is_array($data) || count($data) === 0) {
            return $this->json(['error' => 'Datos inválidos'], $status = 400, $headers = ['Access-Control-Allow-Origin'=>'*']);
        }
        
          // Obtener el usuario autenticado
            $user = $this->getUser();

    // Recorrer la lista de pájaros
        
    foreach ($data['birds'] as $birdData) {
        $name = $birdData['name'];
        $bird = new Totaldata();
        $bird->setName($name);
        $user = $this->getUser();
        $bird->setUser($user);
        $entityManager->persist($bird);
    }
    $bird = new Totaldata();
    $bird->setName('');
    $user = $this->getUser();    
    $bird->setUser($user);
    $entityManager->persist($bird);
    $entityManager->flush();

        //Obtener todos los datos actualizados

        $post = [];

        $result = $totaldataRepository->findAll();
        foreach ($result as $r) {
            $post[] = [
                // 'id' => $r->getId(),
                'name' => $r->getName(),
                'user' => $r->getUser()
            ];
        }

        return $this->json($post, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }
    #[Route('/allbirds', name: 'app_allbird', methods: ['POST', 'GET'])]
    public function AllBird(Request $request, EntityManagerInterface $entityManager, TotaldataRepository $totaldataRepository): Response
    {
    $post = [];

    $result = $totaldataRepository->findAll();
    foreach ($result as $r) {
        $post[] = [
            'id' => $r->getId(),
            'name' => $r->getName(),
            'user' => $r->getUser()
        ];
    }
    return $this->json($post, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
    }
}
