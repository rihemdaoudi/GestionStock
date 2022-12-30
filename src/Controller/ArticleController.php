<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route ("/article", name = "article")
     */
    public function listArticle(): Response
    {
        //récupérer tous les articles de la table article de la BD
        // et les mettre dans le tableau $articles
        $em= $this>getDoctrine()->getManager();
        $articles=$em->getRepository("App\Entity\Article")->findAll();
        return $this->render('article/listArticle.html.twig', [
            "listeArticles"=>$articles

        ]);
    }
    /**
     * @Route("addArticle", name="add_article")
     */
    public function addArticle(Request $request): Response{
        $article = new Article();
        $form = $this ->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persiste($article);
            $em->flush();

            return $this->redirectToRoute('article');
        }

        return $this->render('article/addArticle.html.twig',[
            'formArticle'=>$form->createView()

        ]);
     }

     /**
      * @Route ("/deleteArticle/{id}",name="articleDelete")
      */
     public function deleteArticle($id) : Response{
         $em=$this->getdoctrine()->getManager();
         $article = $em->getRepository("App\Entity\Article")->find($id);
         if($article!== null){
             $em->remove($article);
             $em->flush();
         }else{
             throw new NotFoundHttpException("L'article d'id ".$id."n'existe pas");
         }
         return $this->redirectToRoute('article');

     }
    /**
     * @Route("updateArticle", name="voitureUpdate")
     */
    public function updateArticle(Request $request, $id): Response{
        $em= $this->getDoctrine()->getManager();
        $article = $em ->getRepository("App\Entity\Article")->find($id);

        $editform = $this ->createForm(ArticleType::class, $article);

        $editform->handleRequest($request);
        if($editform->isSubmitted() and $editform->isValid()){
            $em->persiste($article);
            $em->flush();

            return $this->redirectToRoute('article');
        }

        return $this->render('article/updateArticle.html.twig',[
            'editformArticle'=>$editform->createView()

        ]);
    }
    /**
     * @Route ("/searchArticle", name="articleSearch")
     */
    public function searchArticle(Request $request): Response{
        $em = $this->getDoctrine()->getManager();
        $articles= null;

        if($request->isMethod('POST')){
            
        }
    }

}
