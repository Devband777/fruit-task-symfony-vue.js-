<?php

   namespace App\Command;

   use Symfony\Component\Console\Command\Command;
   use Symfony\Component\Console\Input\InputInterface;
   use Symfony\Component\Console\Output\OutputInterface;
   use Symfony\Component\HttpClient\HttpClient;
   use Doctrine\ORM\EntityManagerInterface;
   use App\Entity\Fruit;

   use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

   class FruitFetchCommand extends Command
   {
       protected static $defaultName = 'fruits:fetch';
       private $entityManager;

       public function __construct(EntityManagerInterface $entityManager)
       {
           parent::__construct();
           $this->entityManager = $entityManager;
       }

       protected function configure()
       {
           $this->setDescription('Fetches all fruits from https://fruityvice.com/ and saves them into the local database.');
       }

       protected function execute(InputInterface $input, OutputInterface $output)
       {
           $httpClient = HttpClient::create();
           $response = $httpClient->request('GET', 'https://fruityvice.com/api/fruit/all');
           $fruits = json_decode($response->getContent(), true);

           foreach ($fruits as $fruitData) {
               $fruit = new Fruit();
               $fruit->setName($fruitData['name']);
               $fruit->setFamily($fruitData['family']);
               $fruit->setGenus($fruitData['genus']);
               $fruit->setCarbohydrates($fruitData['nutritions']['carbohydrates']);
               $fruit->setProtein($fruitData['nutritions']['protein']);
               $fruit->setFat($fruitData['nutritions']['fat']);
               $fruit->setCalories($fruitData['nutritions']['calories']);
               $fruit->setSugar($fruitData['nutritions']['sugar']);
               $fruit->setIsFavorite(false);
               $this->entityManager->persist($fruit);
           }

           $this->entityManager->flush();

        //    //If the count of fruits is greater than zero, use Swift Mailer to send an email to the dummy admin email.
        //    $fruitCount = $entityManager->getRepository(Fruit::class)->count([]);

        //     if ($fruitCount > 0) {
        //         $mailer = $this->container->get(MailerInterface::class);

        //         $email = (new Email())
        //             ->from('your_gmail_address')
        //             ->to('test@gmail.com')
        //             ->subject('All fruits have been fetched and saved to the local DB')
        //             ->text('All fruits have been fetched and saved to the local DB.')
        //             ->html('<p>All fruits have been fetched and saved to the local DB.</p>');

        //         $mailer->send($email);
        //     }


           $output->writeln('Fruits successfully fetched and saved to the local database and sent email to you.');

           return 0;
       }
   }