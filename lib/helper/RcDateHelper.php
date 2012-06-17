<?php
use_helper('Date');

function rc_format_datetime($date, $format = 'r')
{
  $date = _adjust_date($date);
  return format_datetime($date->format('U'), $format);
}

function rc_format_date($date, $format = 'r')
{
  $date = _adjust_date($date);
  return format_date($date->format('U'), $format);
}

function _adjust_date($date)
{
  $date = new DateTime($date, new DateTimeZone('GMT'));
  $date->setTimeZone(new DateTimeZone(sfConfig::get('sf_default_timezone', 'Europe/Warsaw')));
  return $date;
}
