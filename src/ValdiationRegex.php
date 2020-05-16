<?php

namespace Selective\Validation;

/**
 * Regex.
 */
final class ValidationRegex
{
    /**
     * ISO date time format: Y-m-d H:i:s.
     */
    const DATE_TIME_ISO = '/^[\d]{4}\-[\d]{2}\-[\d]{2} [\d]{2}\:[\d]{2}\:[\d]{2}$/';

    /**
     * ISO date time format: Y-m-d.
     */
    const DATE_ISO = '/^[\d]{4}\-[\d]{2}\-[\d]{2}$/';

    /**
     * Date format: d.m.Y.
     */
    const DATE_DMY = '/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/';

    /**
     * International phone number.
     */
    const PHONE_NUMBER = '/^\+[0-9]{6,}$/';

    /**
     * ISO 2 country code, e.g. CH, DE, FR.
     */
    const COUNTRY_ISO_2 = '/^[A-Z]{2}$/';

    /**
     * String with no spaces at both ends.
     */
    const TRIMMED = '/^[\S]+(?: +[\S]+)*$/';

    /**
     * Positive integer greater then 1.
     */
    const ID = '/^[1-9][0-9]*$/';

    /**
     * Numeric postal code. Can start with 0. Not for canada.
     */
    const POSTAL_CODE = '/^[\d]{4}$/';

    /**
     * Canada postal code.
     */
    const POSTAL_CODE_CANADA = '/^(?!.*[DFIOQU])[A-VXY][0-9][A-Z] ?[0-9][A-Z][0-9]$/';
}
