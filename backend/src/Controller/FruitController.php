<?php
namespace App\Controller;

use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/fruit")
 */
class FruitController extends AbstractController
{
    /**
     * @Route("", name="fruit_index", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $page = $request->query->get('page', 1);
        $size = $request->query->get('size', 10);
        $name = $request->query->get('name', '');
        $family = $request->query->get('family', '');

        $totalItems= count($entityManager->getRepository(Fruit::class)->findAll());

        $queryBuilder = $entityManager->getRepository(Fruit::class)
        ->createQueryBuilder('f')
        ->orderBy('f.name', 'ASC');

        if (!empty($name)) {
            $queryBuilder->andWhere('LOWER(f.name) LIKE :name')
                ->setParameter('name', '%' . strtolower($name) . '%');
        }

        if (!empty($family)) {
            $queryBuilder->andWhere('LOWER(f.family) LIKE :family')
                ->setParameter('family', '%' . strtolower($family) . '%');
        }

        $fruit = $queryBuilder
                ->setFirstResult(($page - 1) * $size)
                ->setMaxResults($size)
                ->getQuery()
                ->getResult();

        // $fruit = $entityManager->getRepository(Fruit::class)
        //     ->createQueryBuilder('f')
        //     ->orderBy('f.name', 'ASC')
        //     ->setFirstResult(($page-1) * $size)
        //     ->setMaxResults($size)
        //     ->getQuery()
        //     ->getResult();

        return $this->json(["fruit"=>$fruit, "totalItems" => $totalItems]);
    }

    /**
     * @Route("/filter", name="fruit_filter", methods={"GET"})
     */
    public function filter(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 10);
        $name = $request->query->get('name', '');
        $family = $request->query->get('family', '');

        $queryBuilder = $entityManager->getRepository(Fruit::class)
            ->createQueryBuilder('f')
            ->orderBy('f.name', 'ASC');

        if (!empty($name)) {
            $queryBuilder->andWhere('LOWER(f.name) LIKE :name')
                ->setParameter('name', '%' . strtolower($name) . '%');
        }

        if (!empty($family)) {
            $queryBuilder->andWhere('LOWER(f.family) LIKE :family')
                ->setParameter('family', '%' . strtolower($family) . '%');
        }

        $fruit = $queryBuilder
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $this->json($fruit);
    }

    /**
     * @Route("/favorites", name="fruit_favorites", methods={"GET"})
     */
    public function favorites(EntityManagerInterface $entityManager): JsonResponse
    {
        $favorites = $entityManager->getRepository(Fruit::class)
            ->findBy(['isFavorite' => true]);
        $sumOfNuturition = 0;
        foreach($favorites as $favorite) {
            $sumOfNuturition += $favorite->getProtein() + $favorite->getSugar() + $favorite->getFat() + $favorite->getCarbohydrates() + $favorite->getCalories();
        }
        return $this->json(["favorites" => $favorites, "sumOfNutrition" => round($sumOfNuturition, 2)]);
    }

    /**
     * @Route("/{id}/add-to-favorites", name="fruit_add_to_favorites", methods={"POST"})
     */
    public function addToFavorites(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $fruit = $entityManager->getRepository(Fruit::class)
            ->findBy(['isFavorite' => true]);

        if(count($fruit) < 10)
        {
            $fruit = $entityManager->getRepository(Fruit::class)->find($id);

            $fruit->setIsFavorite(true);

            $entityManager->flush();

            return $this->json([
                'message' => $fruit->getName() . ' added to favorites.',
                'favorite' => $fruit,
                'success' => true
            ]);
        }

        else 
            return $this->json([
                'message' => "You can add fruit on favorit list up to 10!",
                'suceess' => false
            ]);
    }

    /**
     * @Route("/{id}/remove-from-favorites", name="fruit_remove_from_favorites", methods={"POST"})
     */
    public function removeFromFavorites(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $fruit = $entityManager->getRepository(Fruit::class)
            ->find($id);

        $fruit->setIsFavorite(false);

        $entityManager->flush();

        return $this->json([
            'message' => 'Fruit removed from favorites.',
            'success' => true
        ]);
    }
}