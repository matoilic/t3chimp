<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Mato Ilic <info@matoilic.ch>
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

class Tx_T3chimp_MailChimp_Field_Address extends Tx_T3chimp_MailChimp_Field_Abstract {
    const TYPE_EXPLODED = 'exploded';
    const TYPE_TEXT = 'text';

    /**
     * @var array all allowed keys in the value array
     */
    private static $allowedKeys = array('addr1', 'addr2', 'state', 'city', 'zip', 'country');

    /**
     * @var Tx_T3chimp_Domain_Repository_CountryRepository
     */
    private $countryRepository;

    /**
     * @var array if this field is required, then those keys must be set and not be empty in the value array
     */
    private static $requiredKeys = array('addr1', 'city', 'zip', 'country', 'state');

    /**
     * @var string
     */
    private $type;

    public function __construct(array $definition, Tx_T3chimp_MailChimp_Form $form) {
        parent::__construct($definition, $form);
        $this->setType(self::TYPE_EXPLODED);
    }


    /**
     * @return string
     */
    public function getAddressLine1() {
        return $this->getField('addr1');
    }

    /**
     * @return string
     */
    public function getAddressLine2() {
        return $this->getField('addr2');
    }

    /**
     * @return string
     */
    public function getCity() {
        return $this->getField('city');
    }

    /**
     * @return string
     */
    public function getCountry() {
        return $this->getField('country');
    }

    /**
     * @return array
     */
    public function getDefaultValue() {
        return array(
            'addr1' => '',
            'addr2' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'country' => $this->definition['defaultcountry_cc'],
        );
    }


    /**
     * @return array
     */
    public function getCountryList() {
        $countries = $this->countryRepository->findAllOrdered();
        $list = array();

        /**
         * @var $country Tx_T3chimp_Domain_Model_Country
         */
        foreach($countries as $iso => $country) {
            $list[] = new Tx_T3chimp_MailChimp_Field_Helper_CountryChoice(
                $this,
                $iso,
                $country
            );
        }

        return $list;
    }

    /**
     * @param string $field
     * @return string
     */
    private function getField($field) {
        $value = $this->getValue();
        return array_key_exists($field, $value) ? $value[$field] : '';
    }

    /**
     * @return bool
     */
    public function getIsTextField() {
        return $this->getType() == self::TYPE_TEXT;
    }

    /**
     * @return string
     */
    public function getState() {
        return $this->getField('state');
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getZipCode() {
        return $this->getField('zip');
    }

    /**
     * @param Tx_T3chimp_Domain_Repository_CountryRepository $repo
     */
    public function injectCountryRepository(Tx_T3chimp_Domain_Repository_CountryRepository $repo) {
        $this->countryRepository = $repo;
    }

    /**
     * @param mixed $value
     */
    public function setApiValue($value) {
        if(!is_array($value)) {
            $this->setType(self::TYPE_TEXT);
        }

        $this->setValue($value);
    }

    /**
     * @param array $value in the format
     *  array('addr1' => '', 'addr2' => '', 'state' => '', 'city' => '', 'zip' => '', 'country' => '')
     * @throws Tx_T3chimp_MailChimp_Exception
     */
    public function setValue($value) {
        if(!$this->getIsTextField()) {
            foreach(array_keys($value) as $key) {
                if(!in_array($key, self::$allowedKeys)) {
                    throw new Tx_T3chimp_MailChimp_Exception('Unallowed key in value ' . htmlentities($key));
                }
            }

            if(!array_key_exists('country', $value) || empty($value['country'])) {
                $value['country'] = $this->definition['defaultcountry_cc'];
            }

            foreach(self::$allowedKeys as $key) {
                if(!array_key_exists($key, $value)) {
                    $value[$key] = '';
                }
            }
        }

        $this->value = $value;

        $this->resetValidation();
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }


    protected function validate() {
        $this->isValidated = TRUE;
        $value = $this->getValue();

        if($this->getIsRequired()) {
            if(!$this->getIsTextField()) {
                foreach(self::$requiredKeys as $key) {
                    if(!array_key_exists($key, $value) || empty($value[$key])) {
                        $this->errors[] = "t3chimp.error.address.$key.required";
                    }
                }
            } else {
                if(strlen($value) == 0) {
                    $this->errors[] = 't3chimp.error.address.required';
                }
            }
        }
    }
}
