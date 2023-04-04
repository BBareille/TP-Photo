<?php

namespace App\Factory;

use App\Entity\Folder;
use App\Repository\FolderRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Folder>
 *
 * @method        Folder|Proxy create(array|callable $attributes = [])
 * @method static Folder|Proxy createOne(array $attributes = [])
 * @method static Folder|Proxy find(object|array|mixed $criteria)
 * @method static Folder|Proxy findOrCreate(array $attributes)
 * @method static Folder|Proxy first(string $sortedField = 'id')
 * @method static Folder|Proxy last(string $sortedField = 'id')
 * @method static Folder|Proxy random(array $attributes = [])
 * @method static Folder|Proxy randomOrCreate(array $attributes = [])
 * @method static FolderRepository|RepositoryProxy repository()
 * @method static Folder[]|Proxy[] all()
 * @method static Folder[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Folder[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Folder[]|Proxy[] findBy(array $attributes)
 * @method static Folder[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Folder[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class FolderFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Folder $folder): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Folder::class;
    }
}
