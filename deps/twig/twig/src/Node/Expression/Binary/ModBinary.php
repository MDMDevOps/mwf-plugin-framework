<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mwf\Lib\Deps\Twig\Node\Expression\Binary;

use Mwf\Lib\Deps\Twig\Compiler;
/** @internal */
class ModBinary extends AbstractBinary
{
    public function operator(Compiler $compiler) : Compiler
    {
        return $compiler->raw('%');
    }
}
