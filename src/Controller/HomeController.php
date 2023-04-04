<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Todolist;

class HomeController extends AbstractController
{

    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $repository = $doctrine->getRepository(Todolist::class);

        $list = $repository->findAll();
       return $this->render('index.html.twig',['list' => $list ]);
    }

    public function addList(ManagerRegistry $doctrine,Request $request): JsonResponse
    {

        if (!$this->isCsrfTokenValid('ajax-token', $request->headers->get('X-Csrf-Token')))
        {
            return new Response('Operation not allowed', 403,
                ['content-type' => 'text/plain']);
        }
            $entityManager = $doctrine->getManager();

            $list = new Todolist();
            $list->setList($request->request->get('list'));
            $list->setStatus(1);

            $entityManager->persist($list);

            $entityManager->flush();

        return $this->json([ 'id' => $list->getId(),'list'=>$list->getlist() ]);
    }

    public function updateOrder(ManagerRegistry $doctrine,Request $request): JsonResponse
    {
        if($request->isXmlHttpRequest()){
            $submittedToken = $request->headers->get('X-Csrf-Token');
            
                if (!$this->isCsrfTokenValid('ajax-token', $submittedToken)) {
                    return new Response('Operation not allowed', 403,
                    ['content-type' => 'text/plain']);
                }
                $order = 1 ;
                foreach(explode(',',$request->request->get('ids')) as $id){

                        $entityManager = $doctrine->getManager();

                          $list =  $entityManager->find(Todolist::class, $id);
                        
                          $list->setPosition($order);
                        
                          $order++;

                        $entityManager->flush();
                }
    
                return $this->json(['data'=>'done', 'msg' => 'Changed Order Successfully']);
            }
    }

    public function completeTask(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        if($request->isXmlHttpRequest()){
            $submittedToken = $request->headers->get('X-Csrf-Token');
            
                if (!$this->isCsrfTokenValid('ajax-token', $submittedToken)) {
                    return new Response('Operation not allowed', 403,
                    ['content-type' => 'text/plain']);
                }

                $entityManager = $doctrine->getManager();

                    $list =  $entityManager->find(Todolist::class, $request->request->get('id'));
                    $status = $list->isStatus() ? 0 : 1;
                    $list->setStatus($status);
                

                $entityManager->flush();

                return $this->json(['data'=>'done', 'msg' => 'Status Changed Successfully']);
            }
    }

    public function deleteTask(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        if($request->isXmlHttpRequest()){
            $submittedToken = $request->headers->get('X-Csrf-Token');
            
                if (!$this->isCsrfTokenValid('ajax-token', $submittedToken)) {
                    return new Response('Operation not allowed', 403,
                    ['content-type' => 'text/plain']);
                }

                $entityManager = $doctrine->getManager();

                    $list =  $entityManager->find(Todolist::class, $request->request->get('id'));

                $entityManager->remove($list) ;
                
                $entityManager->flush();

                return $this->json(['data'=>'done', 'msg' => 'Deleted Successfully']);
            }
    }
}