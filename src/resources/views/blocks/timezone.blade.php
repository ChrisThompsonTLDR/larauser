<?php
static $regions = array(
    \DateTimeZone::AFRICA,
    \DateTimeZone::AMERICA,
    \DateTimeZone::ANTARCTICA,
    \DateTimeZone::ASIA,
    \DateTimeZone::ATLANTIC,
    \DateTimeZone::AUSTRALIA,
    \DateTimeZone::EUROPE,
    \DateTimeZone::INDIAN,
    \DateTimeZone::PACIFIC,
);

$timezones = array();
foreach( $regions as $region )
{
    $timezones = array_merge( $timezones, \DateTimeZone::listIdentifiers( $region ) );
}

$timezone_offsets = array();
foreach( $timezones as $timezone )
{
    $tz = new \DateTimeZone($timezone);
    $timezone_offsets[$timezone] = $tz->getOffset(new \DateTime);
}

// sort timezone by timezone name
ksort($timezone_offsets);

$timezone_list = [];
foreach( $timezone_offsets as $timezone => $offset )
{
    $offset_prefix = $offset < 0 ? '-' : '+';
    $offset_formatted = gmdate( 'H:i', abs($offset) );

    $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

    $t = new \DateTimeZone($timezone);
    $c = new \DateTime(null, $t);
    $current_time = $c->format('g:i A');

    $timezone_list[$timezone] = "(${pretty_offset}) $timezone - $current_time";
}
?>{{ Form::select($name, $timezone_list, (($value) ? $value : config('app.timezone')), $attributes) }}