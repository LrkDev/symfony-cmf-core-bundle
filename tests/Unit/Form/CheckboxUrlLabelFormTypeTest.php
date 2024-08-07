<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\CoreBundle\Tests\Unit\Form;

use Symfony\Cmf\Bundle\CoreBundle\Form\Type\CheckboxUrlLabelFormType;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

class Router implements RouterInterface
{
    public function setContext(RequestContext $context): void
    {
    }

    public function getContext(): RequestContext
    {
    }

    public function match($pathinfo): array
    {
        return [];
    }

    public function getRouteCollection(): RouteCollection
    {
    }

    public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH): string
    {
        return '/test/'.$name;
    }
}

class CheckboxUrlLabelFormTypeTest extends TypeTestCase
{
    public function testContentPathsAreSet(): void
    {
        $checkboxUrlLabelForm = $this->factory->create(CheckboxUrlLabelFormType::class, null, [
            'routes' => ['a' => ['name' => 'a'], 'b' => ['name' => 'b']],
        ]);
        $view = $checkboxUrlLabelForm->createView();

        $this->assertSame('/test/a', $view->vars['paths']['a']);
        $this->assertSame('/test/b', $view->vars['paths']['b']);
    }

    protected function getExtensions(): array
    {
        return array_merge(parent::getExtensions(), [
            new PreloadedExtension([
                CheckboxUrlLabelFormType::class => new CheckboxUrlLabelFormType(new Router()),
            ], []),
        ]);
    }
}
