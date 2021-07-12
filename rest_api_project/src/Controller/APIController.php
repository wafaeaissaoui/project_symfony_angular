<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Realisateur;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class APIController extends AbstractController
{
    private $entityManager;
    private $serializer;
    private $articlesRepo;
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ArticleRepository $articlesRepo,
        CategorieRepository $cat,
        CommentaireRepository $c
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->articlesRepo = $articlesRepo;
        $this->catego = $cat;
        $this->co=$c;
    }


    // public function index(): Response
    // {
    //     return new JsonResponse("test");
    // }

    /**
     * @Route("/articles/liste", name="liste_articles")
     */
    public function liste()
    {
        // On récupère la liste des blog
        $articles = $this->articlesRepo->findAll();

        return new JsonResponse(
            $this->serializer->serialize($articles, 'json', [
                ObjectNormalizer::GROUPS => ['list_article']
            ]),
            200,
            [],
            true
        );
    }
    
    /**
     * @Route("/comments/liste/{id}", name="comments")
     */
    public function listec($id)
    {
        $c=new Commentaire();
        $c = $this->getDoctrine()->getRepository(Commentaire::class)->find($id);
        return new JsonResponse(
            $this->serializer->serialize($c, 'json', [
                ObjectNormalizer::GROUPS => ['list_article']
            ]),
            200,
            [],
            true
        );
    }

    /**
     * @Route("/categoryie/liste", name="liste_categoryie")
     */
    public function listeCat()
    {
        // On récupère la liste des blog
        
        $cat = $this->catego->findAll();

        return new JsonResponse(
            $this->serializer->serialize($cat, 'json', [
                ObjectNormalizer::GROUPS => ['list_cat']
            ]),
            200,
            [],
            true
        );
    }
    //  /**
    //      * @Route("/articlebycat/{id}", name="liste")
    //      */
    //     public function listearticlebycat()
    //     {
    //         // On récupère la liste des blog
    //         $cat = $this->getDoctrine()->getRepository(Categorie::class)->find($id);
    //         return new JsonResponse(
    //             $this->serializer->serialize($cat, 'json', [
    //                 ObjectNormalizer::GROUPS => ['list_cat']
    //             ]),
    //             200,
    //             [],
    //             true
    //         );
    //     }
    /**
     * @param int article
     * 
     * @Route("/lire/{id}", name="article", methods={"GET"})
     */
    public function getArticle($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        return new JsonResponse(
            $this->serializer->serialize($article, 'json', [
                ObjectNormalizer::GROUPS => ['list_article']
            ]),
            200,
            [],
            true
        );





        
    }
    /**
     * @Route("/ajouter", name="ajout", methods={"POST"})
     */
    public function addArticle(Request $request)
    {
        $d=new Categorie();
       
        $article = new Article();
        $donnees = json_decode($request->getContent()); 
        $d->getId($donnees->id);
        $article->setTitre($donnees->titre)
            ->setContenu($donnees->contenu)
            ->setCreatedAt(new \DateTimeImmutable($donnees->created_at))
            ->setImage($donnees->image)
            ->setRealisateur($this->getDoctrine()->getRepository(Realisateur::class)->find(1))
            ->setCategorie($this->getDoctrine()->getRepository(Categoriepo::class)->find($d));
        $this->entityManager->persist($article);
        $this->entityManager->flush();


        return new Response('ok', 200);
    }
    /**
     * @Route("/comment/{id}", name="comment", methods={"POST"})
     */
    public function addComment(Request $request, $id)
    {
        $c = new Commentaire();
        $donnees = json_decode($request->getContent());
        $c->setContenu($donnees->contenu)
            ->setActif($donnees->actif)
            ->setEmail($donnees->email)
            ->setPass($donnees->pass)
            ->setCreatedAt(new \DateTimeImmutable($donnees->created_at))
            ->setArticle($this->getDoctrine()->getRepository(Article::class)->find($id));


        $this->entityManager->persist($c);
        $this->entityManager->flush();


        return new Response('ok', 200);
    }
    /**
     * @Route("/ajoutercat", name="ajoutercat", methods={"POST"})
     */
    public function addCat(Request $request)
    {
        $c = new Categorie();
        $donnees = json_decode($request->getContent());
        $c->setNom($donnees->nom)
            ->setDescription($donnees->description);


        $this->entityManager->persist($c);
        $this->entityManager->flush();


        return new Response('ok', 200);
    }
    /**
     * @Route("/editer/{id}", name="edit", methods={"PUT"})
     */
    public function editArticle(?Article $article, Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $donnees = json_decode($request->getContent());
        $code = 200;
        $article
            ->setTitre($donnees->titre)
            ->setContenu($donnees->contenu)
            ->setCreatedAt(new \DateTimeImmutable($donnees->created_at))
            ->setImage($donnees->image);

        $article->setRealisateur($this->getDoctrine()->getRepository(Realisateur::class)->find(1));
        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return new Response('ok', $code);
    }
    /**
     * @Route("/supprimer/{id}", name="supprime", methods={"DELETE"})
     */
    public function removeArticle($id)
    {
        $article = new Article();
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $this->entityManager->remove($article);
        $this->entityManager->flush();
        return new Response('ok');
    }
}
