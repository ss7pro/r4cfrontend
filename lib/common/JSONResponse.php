<?php
class JSONResponse extends ResponseContent
{
  private $data;
  private $code;

  public function __construct($data, $code = 200)
  {
    $this->data = $data;
    $this->code = $code;
  }

  public function renderResponse(sfResponse $response)
  {
    $response->setStatusCode($this->code);
    $response->setContentType('application/json; charset=' . sfConfig::get('sf_charset', 'utf-8'));
    $response->setContent((string)$this);
    return sfView::NONE;
  }

  public function __toString()
  {
    return json_encode($this->data);
  }
}
