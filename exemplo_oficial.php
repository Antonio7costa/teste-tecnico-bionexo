<?php

// Exemplo oficial (MODO APRESENTAÇÃO - FINAL LENTO)

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Cookie;
use Facebook\WebDriver\WebDriverKeys; 

require_once('vendor/autoload.php');

$host = 'http://localhost:4444/';
$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities);

try {
    // 1. Abre e Maximiza
    $driver->manage()->window()->maximize();
    echo "1. Acessando a página...\n";
    $driver->get('https://en.wikipedia.org/wiki/Selenium_(software)');
    
    sleep(2); 

    // 2. Digita a busca
    echo "2. Pesquisando por 'PHP'...\n";
    $campoBusca = $driver->findElement(WebDriverBy::name('search'));
    
    // Visual: Borda Vermelha na busca
    $driver->executeScript("arguments[0].style.border='3px solid red'", [$campoBusca]);
    sleep(1);
    
    $campoBusca->sendKeys('PHP');
    sleep(1); 
    
    $driver->getKeyboard()->pressKey(WebDriverKeys::ENTER);

    // 3. Espera o resultado
    echo "3. Aguardando resultados...\n";
    $driver->wait()->until(
        WebDriverExpectedCondition::elementTextContains(WebDriverBy::id('firstHeading'), 'PHP')
    );

    sleep(2);

    echo "   -> Título atual: '" . $driver->getTitle() . "'\n";

    // 4. Procura o botão de histórico
    $historyButton = $driver->findElement(
        WebDriverBy::partialLinkText('View history') 
    );

    echo "4. Vou clicar no botão... OLHE A BORDA AMARELA!\n";
    
    // Visual: Borda Vermelha e Fundo Amarelo no botão
    $driver->executeScript("arguments[0].style.border='5px solid red'; arguments[0].style.backgroundColor='yellow';", [$historyButton]);
    
    sleep(3); // Tempo para ver o destaque

    $historyButton->click();

    // 5. Espera a página de histórico carregar
    $driver->wait()->until(
        WebDriverExpectedCondition::titleContains('Revision history')
    );

    echo "   -> Título pós-clique: '" . $driver->getTitle() . "'\n";
    
    // Rola a página para baixo
    $driver->executeScript("window.scrollTo(0, 300);");
    
    // --- MUDANÇA AQUI: PAUSA LONGA NO FINAL ---
    echo "   -> Segurando a página por 8 segundos para você conferir...\n";
    sleep(8); 
    // ------------------------------------------

    $driver->manage()->deleteAllCookies();
    echo "5. Finalizado.\n";

} catch(\Exception $e) {
    echo "ERRO: " . $e->getMessage();
} finally {
    echo "\nFechando navegador...\n";
    if(isset($driver)) $driver->quit();
}