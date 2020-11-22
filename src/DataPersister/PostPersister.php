<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PostPersister
 * @package App\DataPersister
 */
class PostPersister implements DataPersisterInterface
{

    private EntityManagerInterface $em;

    /**
     * PostPersister constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function supports($data): bool
    {
        return $data instanceof Post;
    }

    public function persist($data)
    {
        $data->setCreatedAt(new \DateTime());
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }


}