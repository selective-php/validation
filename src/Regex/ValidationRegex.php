<?php

namespace Selective\Validation\Regex;

/**
 * Regex.
 */
final class ValidationRegex
{
    /**
     * ISO date time format: Y-m-d H:i:s.
     */
    public const DATE_TIME_ISO = '/^[\d]{4}\-[\d]{2}\-[\d]{2} [\d]{2}\:[\d]{2}\:[\d]{2}$/';

    /**
     * ISO date time format: Y-m-d.
     */
    public const DATE_ISO = '/^[\d]{4}\-[\d]{2}\-[\d]{2}$/';

    /**
     * Date format: d.m.Y.
     */
    public const DATE_DMY = '/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/';

    /**
     * International phone number.
     */
    public const PHONE_NUMBER = '/^\+[0-9]{6,}$/';

    /**
     * ISO 2 country code, e.g. CH, DE, FR.
     */
    public const COUNTRY_ISO_2 = '/^[A-Z]{2}$/';

    /**
     * String with no spaces at both ends.
     */
    public const TRIMMED = '/^[\S]+(?: +[\S]+)*$/';

    /**
     * Positive integer >= 1.
     */
    public const ID = '/^[1-9][0-9]*$/';

    /**
     * Generic UUID.
     */
    public const UUID = '/^\w{8}-\w{4}-\w{4}-\w{4}-\w{12}$/';

    /**
     * Postal code. Can start with 0. Not for canada.
     */
    public const POSTAL_CODE = '/^[\d]{4,}$/';

    /**
     * Positive float.
     */
    public const POSITIVE_FLOAT = '/^([\d]*[.])?[\d]+$/';
}
