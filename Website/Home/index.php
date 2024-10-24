<?php
require_once "verificar_sessao.php";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleso.css">
    <title>Tributo a Isaac Newton</title>
</head>
<body>
    <header>
        <h1>Tributo a Isaac Newton</h1>
        <h2>Uma breve homenagem ao gênio da ciência</h2>
    </header>
    
    <main id="main">
        <section id="img-section">
            <div id="img-div">
                <img id="image" src="https://upload.wikimedia.org/wikipedia/commons/f/f7/Portrait_of_Sir_Isaac_Newton%2C_1689_%28brightened%29.jpg" alt="Retrato de Isaac Newton">
                <figcaption id="img-caption">Sir Isaac Newton, um dos maiores cientistas de todos os tempos.</figcaption>
            </div>
        </section>

        <section id="tribute-info">
            <h2>Quem foi Isaac Newton?</h2>
            <p>Sir Isaac Newton (1643–1727) foi um matemático, físico, astrônomo e teólogo inglês, amplamente reconhecido como uma das figuras mais importantes da história da ciência.</p>
            <p>Newton é conhecido por suas leis do movimento, a teoria da gravitação universal e por suas contribuições fundamentais à óptica e ao cálculo. Sua obra 'Philosophiæ Naturalis Principia Mathematica' lançou as bases da mecânica clássica.</p>
            <p>Além de suas realizações científicas, Newton teve um grande impacto na filosofia natural e na Revolução Científica, transformando a forma como compreendemos o mundo físico.</p>
        </section>
    </main>

    <footer>
        <p>Este site foi criado para homenagear Isaac Newton. Para mais informações, visite a <a href="https://pt.wikipedia.org/wiki/Isaac_Newton" target="_blank">Wikipedia</a>.</p>
        <p>Saiba quem mais cadastrou no nosso site <a href="../Search/?pagination=0&pesquisaUsuario=%%">Pesquise</a>.</p>
    </footer>
</body>
</html>
