<?php get_header(); ?>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-container">
        <!-- PANEL IZQUIERDO -->
        <div class="left-panel">
            <h1 class="mb-4">Selecciona un grupo muscular</h1>
            <select id="grupoMuscular" class="mb-4">
                <option value="">-- Elige una opción --</option>
                <option value="pecho">Pecho</option>
                <option value="espalda">Espalda</option>
                <option value="piernas">Piernas</option>
                <option value="brazos">Brazos</option>
                <option value="abdomen">Abdomen</option>
                <option value="hombros">Hombros</option>
                <option value="gluteos">Glúteos</option>
            </select>

            <!-- Aquí se cargarán las tarjetas de ejercicios -->
            <div id="cards-container" class="row row-cols-1 row-cols-md-2 g-4"></div>
        </div>

        <!-- PANEL DERECHO -->
        <div class="right-panel">
            <img src="./MuscleGroupBaseImageTransparentBackground.png" alt="Silueta cuerpo humano" class="imagen-cuerpo" usemap="#cuerpo" />
            <map name="cuerpo">
                <area alt="Cabeza" title="Cabeza" onclick="mostrarEjercicios('cabeza')" coords="431,169,528,169,541,267,535,321,491,324,428,314,415,245" shape="poly"/>
                <area alt="Biceps" title="Biceps" onclick="mostrarEjercicios('biceps')" coords="297,577,275,640,253,654,239,642,244,588,263,547,285,537,293,554" shape="poly">
                <area alt="Biceps" title="Biceps" onclick="mostrarEjercicios('biceps')" coords="678,536,668,573,685,626,700,649,723,653,725,624,721,593,713,571,696,546" shape="poly">
                <area alt="Pecho" title="Pecho" onclick="mostrarEjercicios('pecho')" coords="434,420,454,425,468,445,471,459,475,479,475,498,473,518,470,538,461,557,443,571,417,574,393,574,370,569,354,557,348,542,339,523,339,505,339,482,341,466,348,449,363,437,375,430,388,423,409,420" shape="poly">
                <area alt="Pecho" title="Pecho" onclick="mostrarEjercicios('pecho')" coords="513,423,535,423,557,420,576,423,596,430,608,440,617,451,622,464,625,481,627,498,624,515,619,532,612,549,600,563,585,569,564,576,547,576,530,573,517,568,503,561,496,552,490,539,490,520,490,505,490,491,490,474,493,461,496,446,503,432" shape="poly">
            </map>
        </div>
    </div>

   <?php get_footer(); ?> 
    