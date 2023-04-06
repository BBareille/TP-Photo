<?php

namespace App\Factory;

use App\Entity\Photographer;
use App\Repository\PhotographerRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Photographer>
 *
 * @method        Photographer|Proxy create(array|callable $attributes = [])
 * @method static Photographer|Proxy createOne(array $attributes = [])
 * @method static Photographer|Proxy find(object|array|mixed $criteria)
 * @method static Photographer|Proxy findOrCreate(array $attributes)
 * @method static Photographer|Proxy first(string $sortedField = 'id')
 * @method static Photographer|Proxy last(string $sortedField = 'id')
 * @method static Photographer|Proxy random(array $attributes = [])
 * @method static Photographer|Proxy randomOrCreate(array $attributes = [])
 * @method static PhotographerRepository|RepositoryProxy repository()
 * @method static Photographer[]|Proxy[] all()
 * @method static Photographer[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Photographer[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Photographer[]|Proxy[] findBy(array $attributes)
 * @method static Photographer[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Photographer[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class PhotographerFactory extends ModelFactory
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
            'email' => self::faker()->text(180),
            'password' => self::faker()->text(),
            'roles' => [],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Photographer $photographer): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Photographer::class;
    }
}
