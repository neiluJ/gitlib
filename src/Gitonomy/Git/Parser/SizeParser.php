<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\Git\Parser;

/**
 * Parses Repository size using 'git count-objects'.
 * 
 * @author Julien Ballestracci <julien@nitronet.org>
 */
class SizeParser extends ParserBase
{
    public $objects;
    public $size;
    public $inPack;
    public $packs;
    public $sizePack;
    public $prunePackable;
    public $garbage;
    
    protected function doParse()
    {
        while (!$this->isFinished()) {
            $this->consume("count: ");
            $this->objects = $this->consumeTo("\n");
            $this->consumeNewLine();
            $this->consume("size: ");
            $this->size = $this->consumeTo("\n");
            $this->consumeNewLine();
            $this->consume("in-pack: ");
            $this->inPack = $this->consumeTo("\n");
            $this->consumeNewLine();
            $this->consume("packs: ");
            $this->packs = $this->consumeTo("\n");
            $this->consumeNewLine();
            $this->consume("size-pack: ");
            $this->sizePack = $this->consumeTo("\n");
            $this->consumeNewLine();
            $this->consume("prune-packable: ");
            $this->prunePackable = $this->consumeTo("\n");
            $this->consumeNewLine();
            $this->consume("garbage: ");
            $this->garbage = $this->consumeTo("\n");
            $this->consumeNewLine();
        }
    }
}