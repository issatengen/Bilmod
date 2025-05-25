<?php

namespace App\Tests\Controller;

use App\Entity\Leson;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LesonControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $lesonRepository;
    private string $path = '/leson/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->lesonRepository = $this->manager->getRepository(Leson::class);

        foreach ($this->lesonRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Leson index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'leson[lesonCode]' => 'Testing',
            'leson[lesonTitle]' => 'Testing',
            'leson[timeAllocated]' => 'Testing',
            'leson[user]' => 'Testing',
            'leson[Course]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->lesonRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Leson();
        $fixture->setLesonCode('My Title');
        $fixture->setLesonTitle('My Title');
        $fixture->setTimeAllocated('My Title');
        $fixture->setUser('My Title');
        $fixture->setCourse('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Leson');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Leson();
        $fixture->setLesonCode('Value');
        $fixture->setLesonTitle('Value');
        $fixture->setTimeAllocated('Value');
        $fixture->setUser('Value');
        $fixture->setCourse('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'leson[lesonCode]' => 'Something New',
            'leson[lesonTitle]' => 'Something New',
            'leson[timeAllocated]' => 'Something New',
            'leson[user]' => 'Something New',
            'leson[Course]' => 'Something New',
        ]);

        self::assertResponseRedirects('/leson/');

        $fixture = $this->lesonRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getLesonCode());
        self::assertSame('Something New', $fixture[0]->getLesonTitle());
        self::assertSame('Something New', $fixture[0]->getTimeAllocated());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getCourse());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Leson();
        $fixture->setLesonCode('Value');
        $fixture->setLesonTitle('Value');
        $fixture->setTimeAllocated('Value');
        $fixture->setUser('Value');
        $fixture->setCourse('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/leson/');
        self::assertSame(0, $this->lesonRepository->count([]));
    }
}
