<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Validator;

class UniqueEntity extends \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity
{
    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
