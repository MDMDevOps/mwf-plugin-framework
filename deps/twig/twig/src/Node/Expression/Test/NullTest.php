<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mwf\Lib\Deps\Twig\Node\Expression\Test;

use Mwf\Lib\Deps\Twig\Compiler;
use Mwf\Lib\Deps\Twig\Node\Expression\TestExpression;
/**
 * Checks that a variable is null.
 *
 *  {{ var is none }}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @internal
 */
class NullTest extends TestExpression
{
    public function compile(Compiler $compiler) : void
    {
        $compiler->raw('(null === ')->subcompile($this->getNode('node'))->raw(')');
    }
}
