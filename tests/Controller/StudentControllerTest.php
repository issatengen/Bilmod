<?php

namespace App\Tests\Controller;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class StudentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $studentRepository;
    private string $path = '/student/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->studentRepository = $this->manager->getRepository(Student::class);

        foreach ($this->studentRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Student index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'student[StudentCode]' => 'Testing',
            'student[studentFirstName]' => 'Testing',
            'student[studentName]' => 'Testing',
            'student[studentEmail]' => 'Testing',
            'student[studentPhoto]' => 'Testing',
            'student[studentPassword]' => 'Testing',
            'student[user]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->studentRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Student();
        $fixture->setStudentCode('My Title');
        $fixture->setStudentFirstName('My Title');
        $fixture->setStudentName('My Title');
        $fixture->setStudentEmail('My Title');
        $fixture->setStudentPhoto('My Title');
        $fixture->setStudentPassword('My Title');
        $fixture->setUser('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Student');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Student();
        $fixture->setStudentCode('Value');
        $fixture->setStudentFirstName('Value');
        $fixture->setStudentName('Value');
        $fixture->setStudentEmail('Value');
        $fixture->setStudentPhoto('Value');
        $fixture->setStudentPassword('Value');
        $fixture->setUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'student[StudentCode]' => 'Something New',
            'student[studentFirstName]' => 'Something New',
            'student[studentName]' => 'Something New',
            'student[studentEmail]' => 'Something New',
            'student[studentPhoto]' => 'Something New',
            'student[studentPassword]' => 'Something New',
            'student[user]' => 'Something New',
        ]);

        self::assertResponseRedirects('/student/');

        $fixture = $this->studentRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getStudentCode());
        self::assertSame('Something New', $fixture[0]->getStudentFirstName());
        self::assertSame('Something New', $fixture[0]->getStudentName());
        self::assertSame('Something New', $fixture[0]->getStudentEmail());
        self::assertSame('Something New', $fixture[0]->getStudentPhoto());
        self::assertSame('Something New', $fixture[0]->getStudentPassword());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Student();
        $fixture->setStudentCode('Value');
        $fixture->setStudentFirstName('Value');
        $fixture->setStudentName('Value');
        $fixture->setStudentEmail('Value');
        $fixture->setStudentPhoto('Value');
        $fixture->setStudentPassword('Value');
        $fixture->setUser('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/student/');
        self::assertSame(0, $this->studentRepository->count([]));
    }
}
