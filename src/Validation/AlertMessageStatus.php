<?php

namespace Odan\Validation;

/**
 * AlertStatus.
 *
 * Can be used in combination with AlertMessage.
 */
class AlertMessageStatus
{
    // Bootstrap
    const PRIMARY = 'primary';

    // Bootstrap
    const SECONDARY = 'secondary';

    // Bootstrap
    const SUCCESS = 'success';

    // Bootstrap
    const DANGER = 'danger';

    // Bootstrap
    const LIGHT = 'light';

    // Bootstrap
    const DARK = 'dark';

    // RFC 5424
    const DEBUG = 'debug';

    // RFC 5424 and Bootstrap
    const INFO = 'info';

    const NOTICE = 'notice';

    // RFC 5424 and Bootstrap
    const WARNING = 'warning';

    // RFC 5424
    const ERROR = 'error';

    // RFC 5424
    const CRITICAL = 'critical';

    // RFC 5424
    const ALERT = 'alert';

    // RFC 5424
    const EMERGENCY = 'emergency';
}
