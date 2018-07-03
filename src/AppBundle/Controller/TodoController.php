<?php

namespace AppBundle\Controller;

use \DateTime;
use AppBundle\Entity\Todo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    /**
     * @Route("/todos", name="todo_list")
     */
    public function listAction(){
        $todos = $this->getDoctrine()
                ->getRepository('AppBundle:Todo')
                ->findAll();

        return $this->render('todo/index.html.twig', array(
            'todos' => $todos
        ));
    }

    /**
     * @Route("/todo/add", name="todo_add")
     */
    public function addAction(){
        return $this->render('todo/form.html.twig', array(
            'formTitle' => "Add Todo"
        ));
    }

    /**
     * @Route("/todo/act", name="todo_act")
     */
    public function actAction($id=null, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        $todo = new Todo();
        $name=$request->request->get('name');
        $category=$request->request->get('category');
        $description=$request->request->get('description');
        $priority=$request->request->get('priority');
        $due_date=$request->request->get('due_date');
        $now= new \DateTime("now");

        $todo->setName($name);
        $todo->setCategory($category);
        $todo->setDescription($description);
        $todo->setPriority($priority);
        $todo->setDueDate(new \DateTime($due_date));
        $todo->setCreateDate($now);

        $entityManager->persist($todo);
        $entityManager->flush();

        return new Response('Todo Saved');

       
    }

    /**
     * @Route("/todo/edit/{id}", name="todo_edit")
     */
    public function editAction($id, Request $request) {
        return $this->render('todo/form.html.twig', array(
            'formTitle' => "Edit Todo"
        ));
    }
    
    /**
     * @Route("/todo/detais/{id}", name="todo_detail")
     */
    public function detailsAction($id) {
        return;
    }

}
