<?php
/**
 * Created by PhpStorm.
 * User: kaduppg
 * Date: 11/28/18
 * Time: 9:46 PM
 */

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */

class BlogController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;

    }

    /**
     * @Route("/", name="blog_index" )
     */
    public function index(){
        return $this->render( "blog/index.html.twig",
                ['posts'=> $this->session->get('posts')]);
    }

    /**
     * @Route("/add" , name="blog_add")
     */
    public function add(){
        $posts = $this->session->get('posts');
        $posts[uniqid()] = [
            "title"=> "A random title ". rand(1,500),
            "text" => " A random text nr ". rand(1,500),
            "date" => new \DateTime()
        ];

        $this->session->set('posts',$posts );

        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/show/{id}", name="blog_show")
     */
    public function show($id){

        $posts = $this->session->get('posts');

        if(!$posts || !isset($posts[$id]) ){
            throw new NotFoundHttpException("Post not Found");
        }

        return $this->render('blog/post.html.twig', [
            'id' =>$id,
            'post'=>$posts[$id]
        ]);
    }


}