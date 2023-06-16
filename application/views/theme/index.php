<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  $this->load->view('theme/header');
  $this->load->view($content);
  $this->load->view('theme/footer');

?>
