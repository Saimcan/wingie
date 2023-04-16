<?php

namespace App\Factory;

use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Developer>
 *
 * @method        Developer|Proxy create(array|callable $attributes = [])
 * @method static Developer|Proxy createOne(array $attributes = [])
 * @method static Developer|Proxy find(object|array|mixed $criteria)
 * @method static Developer|Proxy findOrCreate(array $attributes)
 * @method static Developer|Proxy first(string $sortedField = 'id')
 * @method static Developer|Proxy last(string $sortedField = 'id')
 * @method static Developer|Proxy random(array $attributes = [])
 * @method static Developer|Proxy randomOrCreate(array $attributes = [])
 * @method static DeveloperRepository|RepositoryProxy repository()
 * @method static Developer[]|Proxy[] all()
 * @method static Developer[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Developer[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Developer[]|Proxy[] findBy(array $attributes)
 * @method static Developer[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Developer[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class DeveloperFactory extends ModelFactory
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
            'level' => self::faker()->randomNumber(),
            'name' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Developer $developer): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Developer::class;
    }
}
