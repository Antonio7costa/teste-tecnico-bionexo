<?php

// Exemplo oficial do php-webdriver (com correções de janela)

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Cookie;

require_once('vendor/autoload.php');

// Define onde o servidor (Chromedriver) está rodando
$host = 'http://localhost:4444/';

// Configura para usar o Chrome
$capabilities = DesiredCapabilities::chrome();

// Cria a conexão com o navegador
$driver = RemoteWebDriver::create($host, $capabilities);

try {
    // --- CORREÇÃO IMPORTANTE: Maximizar a janela ---
    // Isso garante que a barra de busca esteja visível e clicável
    $driver->manage()->window()->maximize();

    // 1. Navegar para a página Selenium na Wikipedia
    echo "1. Acessando a página...\n";
    $driver->get('https://en.wikipedia.org/wiki/Selenium_(software)');

    // 2. Escrever 'PHP' na busca e enviar
    echo "2. Pesquisando por 'PHP'...\n";
    $campoBusca = $driver->findElement(WebDriverBy::id('searchInput'));
    $campoBusca->sendKeys('PHP');
    $campoBusca->submit();

    // 3. Esperar até que 'PHP' apareça no título principal (h1)
    echo "3. Aguardando resultados...\n";
    $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(WebDriverBy::id('firstHeading'), 'PHP')
    );

    // Imprimir título e URL
    echo "   -> Título atual: '" . $driver->getTitle() . "'\n";
    echo "   -> URL atual: '" . $driver->getCurrentURL() . "'\n";

    // 4. Encontrar o botão 'View history' (Ver histórico)
    // Nota: O seletor original '#ca-history a' pode variar dependendo da skin da wiki, 
    // mas geralmente funciona.
    $historyButton = $driver->findElement(
        WebDriverBy::cssSelector('#ca-history a')
    );

    echo "4. Botão encontrado: '" . $historyButton->getText() . "'\n";

    // Clicar no botão
    $historyButton->click();

    // 5. Esperar a página de histórico carregar
    $driver->wait()->until(
        WebDriverExpectedCondition::titleContains('Revision history')
    );

    echo "   -> Título pós-clique: '" . $driver->getTitle() . "'\n";
    echo "   -> URL pós-clique: '" . $driver->getCurrentURL() . "'\n";

    // 6. Manipulação de Cookies (Extra)
    $driver->manage()->deleteAllCookies();
    $cookie = new Cookie('cookie_teste', 'valor_teste');
    $driver->manage()->addCookie($cookie);
    
    echo "5. Cookies manipulados com sucesso.\n";
    print_r($driver->manage()->getCookies());

} catch(\Exception $e) {
    echo "ERRO FATAL: " . $e->getMessage();
} finally {
    // Fecha o navegador no final, mesmo se der erro
    echo "\nFechando navegador...\n";
    if(isset($driver)) $driver->quit();
}