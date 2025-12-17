Markdown

# 🤖 Automação de Busca na Wikipedia com PHP e Selenium

Este projeto é um exemplo prático de **RPA (Robotic Process Automation)** desenvolvido em PHP. O robô simula o comportamento humano navegando na web, realizando buscas, interagindo com elementos dinâmicos e extraindo informações.

## 🚀 Funcionalidades
* **Interação Humana:** Digita textos e clica em botões.
* **Tratamento de Latência:** Utiliza *Explicit Waits* para aguardar o carregamento de elementos (evita erros se a internet estiver lenta).
* **Bypass de Elementos:** Solução robusta para lidar com atualizações de DOM dinâmicas da Wikipedia.
* **Feedback Visual:** O robô destaca (com bordas coloridas) os elementos onde está clicando para facilitar apresentações.

## 🛠️ Tecnologias Utilizadas
* **Linguagem:** PHP 8+
* **Automação:** Selenium WebDriver
* **Dependências:** php-webdriver/webdriver (via Composer)
* **Ambiente:** Linux (WSL2)

## 📦 Como rodar este projeto

Clone o repositório:
```bash
git clone https://github.com/Antonio7costa/teste-tecnico-bionexo.git
```

Instale as dependências:
```bash
composer install
```

Inicie o servidor do ChromeDriver (em um terminal separado):
```bash
chromedriver --port=4444
```

Execute o robô:
```bash
php exemplo_oficial.php
```