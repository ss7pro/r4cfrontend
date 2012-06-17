<?php
function include_javascripts_options($var_name = 'options')
{
  echo get_javascripts_options($var_name);
}

function get_javascripts_options($var_name = 'options')
{
  javascript_tag();
  $data = array(
    'urlBase' => url_for('default/index'),
    'lang'    => sfContext::getInstance()->getUser()->getCulture()
  );
  echo "var $name = {};\n$name.config = " . json_encode($data) . ';';
  return end_javascript_tag() . "\n";
}
