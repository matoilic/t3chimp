<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Mato Ilic <info@matoilic.ch>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

interface MailChimp_Field
{
    /**
     * @abstract
     * @return mixed
     */
    public function getDefaultValue();

    /**
     * @abstract
     * @return array
     */
    public function getErrors();

    /**
     * @abstract
     * @return string
     */
    public function getId();

    /**
     * @abstract
     * @return boolean
     */
    public function getIsRequired();

    /**
     * @abstract
     * @return boolean
     */
    public function getIsValid();

    /**
     * @abstract
     * @return string
     */
    public function getLabel();

    /**
     * @abstract
     * @return string
     */
    public function getName();

    /**
     * @abstract
     * @return string
     */
    public function getTag();

    /**
     * @abstract
     * @return string
     */
    public function getTemplate();

    /**
     * @abstract
     * @return mixed
     */
    public function getValue();

    /**
     * @abstract
     * @param mixed $value
     * @return void
     */
    public function setValue($value);
}
