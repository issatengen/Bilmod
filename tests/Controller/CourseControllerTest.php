<?php

namespace App\Tests\Controller;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CourseControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $courseRepository;
    private string $path = '/course/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->courseRepository = $this->manager->getRepository(Course::class);

        foreach ($this->courseRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Course index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'course[courseCode]' => 'Testing',
            'course[courseTitle]' => 'Testing',
            'course[price]' => 'Testing',
            'course[user]' => 'Testing',
            'course[category]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->courseRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Course();
        $fixture->setCourseCode('My Title');
        $fixture->setCourseTitle('My Title');
        $fixture->setPrice('My Title');
        $fixture->setUser('My Title');
        $fixture->setCategory('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Course');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Course();
        $fixture->setCourseCode('Value');
        $fixture->setCourseTitle('Value');
        $fixture->setPrice('Value');
        $fixture->setUser('Value');
        $fixture->setCategory('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'course[courseCode]' => 'Something New',
            'course[courseTitle]' => 'Something New',
            'course[price]' => 'Something New',
            'course[user]' => 'Something New',
            'course[category]' => 'Something New',
        ]);

        self::assertResponseRedirects('/course/');

        $fixture = $this->courseRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getCourseCode());
        self::assertSame('Something New', $fixture[0]->getCourseTitle());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getCategory());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Course();
        $fixture->setCourseCode('Value');
        $fixture->setCourseTitle('Value');
        $fixture->setPrice('Value');
        $fixture->setUser('Value');
        $fixture->setCategory('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/course/');
        self::assertSame(0, $this->courseRepository->count([]));
    }
}
