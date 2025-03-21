<?php

namespace App\Tests\Integration\Service\Animal\Photo\Uploader\PathGenerator;

use App\Service\Animal\Photo\Uploader\PathGenerator\PathGenerator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\String\Slugger\SluggerInterface;

final class PathGeneratorTest extends KernelTestCase
{
    private SluggerInterface $slugger;
    private string $basePathServer;
    private string $basePathWeb;
    private int $year;
    private int $month;

    protected function setUp(): void {
        self::bootKernel();

        $this->slugger = static::getContainer()->get(SluggerInterface::class);
        $this->basePathServer = '/server/dir/';
        $this->basePathWeb = '/web/dir/';

        $this->year = 2025;
        $this->month = 2;
    }

    /**
     * @dataProvider provider
     */
    public function testGetServerDirectory(string $animalInternalId, string $expected): void
    {
        $pathGenerator = new PathGenerator(
            $this->slugger,
            $this->basePathServer,
            $this->basePathWeb
        );

        $expected = sprintf('/server/dir/%s/%s/5-2025', $this->year, $this->month);

        $path = $pathGenerator->getServerDirectory($animalInternalId, $this->year, $this->month);
        $this->assertSame($expected, $path);

        $path = $pathGenerator->getServerDirectory($animalInternalId, $this->year, $this->month);
        $this->assertSame($expected, $path);

        $path = $pathGenerator->getServerDirectory($animalInternalId, $this->year, $this->month);
        $this->assertSame($expected, $path);
    }

    /**
     * @dataProvider provider
     */
    public function testGetWebDirectory(string $animalInternalId, string $expected): void
    {
        $pathGenerator = new PathGenerator(
            $this->slugger,
            $this->basePathServer,
            $this->basePathWeb
        );

        $expected = sprintf('/web/dir/%s/%s/5-2025', $this->year, $this->month);

        $path = $pathGenerator->getWebDirectory($animalInternalId, $this->year, $this->month);
        $this->assertSame($expected, $path);

        $path = $pathGenerator->getWebDirectory($animalInternalId, $this->year, $this->month);
        $this->assertSame($expected, $path);

        $path = $pathGenerator->getWebDirectory($animalInternalId, $this->year, $this->month);
        $this->assertSame($expected, $path);
    }

    public function provider()
    {
        return [
            ['5-2025', '5-2025'],
            ['5/2025', '5-2025'],
            ['5_2025', '5-2025'],
        ];
    }
}