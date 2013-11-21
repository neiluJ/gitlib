<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\Git;

/**
 * Size informations about a repository
 *
 * @author Julien Ballestracci <julien@nitronet.org>
 */
class Size
{
    /**
     * Repository object.
     *
     * @var Gitonomy\Git\Repository
     */
    protected $repository;

    /**
     * A boolean indicating if the size is already initialized.
     *
     * @var boolean
     */
    protected $initialized = false;
    
    protected $objects;
    protected $size;
    protected $inPack;
    protected $packs;
    protected $sizePack;
    protected $prunePackable;
    protected $garbage;
    
    /**
     * Constructor.
     *
     * @param Gitonomy\Git\Repository $repository The repository
     */
    public function __construct($repository)
    {
        $this->repository  = $repository;
        $this->initialize();
    }
    
    protected function initialize()
    {
        if (true === $this->initialized) {
            return;
        }

        try {
            $parser = new Parser\SizeParser();
            $output = $this->repository->run('count-objects', array('-v'));
        } catch (RuntimeException $e) {
            $output = $e->getOutput();
            $error  = $e->getErrorOutput();
            if (!empty($error)) {
                throw new RuntimeException('Error while getting repository size: '.$error);
            }
        }
        $parser->parse($output);
        
        $this->objects = $parser->objects;
        $this->size = $parser->size;
        $this->garbage = $parser->garbage;
        $this->prunePackable = $this->prunePackable;
        $this->sizePack = $parser->sizePack;
        $this->packs = $parser->packs;
        $this->inPack = $parser->inPack;
        
        $this->initialized = true;
    }
    
    /**
     * Objects count in repository
     * 
     * @return integer
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * Repository Disk Size
     * 
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * In-pack objects count
     * 
     * @return integer
     */
    public function getInPack()
    {
        return $this->inPack;
    }

    /**
     * Number of packs
     * 
     * @return integer
     */
    public function getPacks()
    {
        return $this->packs;
    }

    /**
     * Packs Disk size
     * 
     * @return integer
     */
    public function getSizePack()
    {
        return $this->sizePack;
    }

    /**
     * Number of objects that can be removed by running git prune-packed
     * 
     * @return type 
     */
    public function getPrunePackable()
    {
        return $this->prunePackable;
    }

    /**
     * Number of files that are not valid loose objects nor valid packs
     * 
     * @return integer
     */
    public function getGarbage()
    {
        return $this->garbage;
    }
}