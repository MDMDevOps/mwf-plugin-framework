<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mwf\Lib\Deps\Twig\Node\Expression\Binary;

use Mwf\Lib\Deps\Twig\Compiler;
/** @internal */
class HasEveryBinary extends AbstractBinary
{
    public function compile(Compiler $compiler) : void
    {
        $compiler->raw('twig_array_every($this->env, ')->subcompile($this->getNode('left'))->raw(', ')->subcompile($this->getNode('right'))->raw(')');
    }
    public function operator(Compiler $compiler) : Compiler
    {
        return $compiler->raw('');
    }
}
