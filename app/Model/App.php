<?php declare(strict_types = 1);

namespace App\Model;

final class App
{

	public const DESTINATION_FRONT_HOMEPAGE = ':Front:Home:';
	public const DESTINATION_ADMIN_HOMEPAGE = ':Admin:Home:';
	public const DESTINATION_SIGN_IN = ':Admin:Sign:in';
	public const DESTINATION_AFTER_SIGN_IN = self::DESTINATION_ADMIN_HOMEPAGE;
	public const DESTINATION_AFTER_SIGN_OUT = self::DESTINATION_FRONT_HOMEPAGE;

    public const DATETIME_FORMAT = "j. n. Y H:i";
    public const DATETIME_SECONDS_FORMAT = 'j. n. Y H:i:s';
    public const DATE_FORMAT = "j. n. Y";
    public const DATE_SHORT_FORMAT = "j. n.";
    public const TIME_FORMAT = "H:i";
    public const TIME_SECONDS_FORMAT = "H:i:s";

    public const DATE_PICKER_FORMAT = 'Y-m-d';
    public const DATE_PICKER_MAX_VALUE = '9999-12-31';
    public const DATETIME_PICKER_FORMAT = 'Y-m-d\TH:i';
    public const DATETIME_SECONDS_PICKER_FORMAT = 'Y-m-d\TH:i:s';
    public const DATETIME_MILLISECONDS_PICKER_FORMAT = 'Y-m-d\TH:i:s.v';

    public const DATETIME_PICKER_MAX_VALUE = "9999-12-31T23:59";
    public const SERVICE_TIME = '6 months';
    public const BIKE_DISTANCE_DELIVERY = 50;
}
