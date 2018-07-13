<?php

class Refresh {
  public $contas;
  public $estabs;
  public $enderecos;
  public $produtos;
  public $promocoes;

  function setContas($contas) {
    $this->contas = $contas;
  }

  function setEstabs ($estabs) {
    $this->estabs = $estabs;
  }

  function setEnds($enderecos) {
    $this->enderecos = $enderecos;
  }

  function setProds($produtos) {
    $this->produtos = $produtos;
  }

  function setProms($promocoes) {
    $this->promocoes = $promocoes;
  }
}

?>
