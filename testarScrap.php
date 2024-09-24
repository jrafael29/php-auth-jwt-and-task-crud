<?php
// URL ou HTML da página que você quer acessar
$html = file_get_contents('https://www.resultadofacil.com.br/resultado-do-jogo-do-bicho/PB');

// Criando a instância do DOMDocument
$dom = new DOMDocument();
@$dom->loadHTML($html);

// Criando um XPath para navegar no DOM
$xpath = new DOMXPath($dom);

// Seleciona todas as <div> que possuem a classe "row collapse in"
$divs = $xpath->query('//div[contains(@class, "row collapse in")]');

// Loop por cada <div>
foreach ($divs as $div) {

  // Procurar todas as tabelas dentro da div
  $tables = $div->getElementsByTagName('table');

  $titles = $div->getElementsByTagName('h3');

  $title1 = "";
  $title2 = "";
  $title3 = "";
  $title4 = "";
  $title5 = "";
  $title6 = "";

  // Verificar se há títulos suficientes antes de acessar
  for ($i = 0; $i < $titles->length & $i < 6; $i++) {
    $title = $titles->item($i)->nodeValue;
    switch ($i) {
      case 0:
        $title1 = $title;
        break;
      case 1:
        $title2 = $title;
        break;
      case 2:
        $title3 = $title;
        break;
      case 3:
        $title4 = $title;
        break;
      case 4:
        $title5 = $title;
        break;
      case 5:
        $title6 = $title;
        break;
    }
  }

  $diaResultados = [];

  // Usar uma variável separada para os índices das tabelas
  $tableIndex = 0;

  // Loop por cada tabela encontrada
  foreach ($tables as $table) {
    // Pega todas as linhas <tr> da tabela
    $rows = $table->getElementsByTagName('tr');
    
    $resultado = [];
    
    // Loop pelas linhas da tabela
    foreach ($rows as $row) {
      $cols = $row->getElementsByTagName('td');
      $data = [];
      
      // Extrair dados de cada célula <td>
      foreach ($cols as $index => $col) {
        $keyName = "";
        switch ($index) {
          case 0:
            $keyName = "Premio";
            break;
          case 1:
            $keyName = "Milhar";
            break;
          case 2:
            $keyName = "Grupo";
            break;
          case 3:
            $keyName = "Bicho";
            break;
        }
        $data[] = [$keyName => $col->nodeValue];
      }
      
      if (!empty($data)) {
        $resultado[] = $data;
      }
    }
    
    // Atribuir o título correto baseado no índice da tabela
    $titleL = "";
    switch ($tableIndex) {
      case 0:
        $titleL = $title1;
        break;
      case 1:
        $titleL = $title2;
        break;
      case 2:
        $titleL = $title3;
        break;
      case 3:
        $titleL = $title4;
        break;
      case 4:
        $titleL = $title5;
        break;
      case 5:
        $titleL = $title6;
        break;
    }
    
    // Incrementar o índice das tabelas
    $tableIndex++;
    
    // Associar o título com o resultado da tabela
    $diaResultados[] = [$titleL => $resultado];
  }
  $dataAtual = date("d-m-Y");

  file_put_contents("./raspagens/$dataAtual.json", json_encode($diaResultados));
  // Exibir o resultado em formato JSON
  echo json_encode($diaResultados);
}

?>
