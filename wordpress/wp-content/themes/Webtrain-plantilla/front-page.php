<?php get_header(); ?>

<!-- CONTENIDO PRINCIPAL -->
 <div class="theme-switch">
    <input type="checkbox" id="theme-toggle" name="theme-toggle">
    <label for="theme-toggle"></label>
    <span for="theme-toggle">Cambiar tema</span>
</div>
<div class="main-container">
    <!-- PANEL IZQUIERDO -->
    <div class="left-panel">

        <div class="row mb-4 w-100">
            <div class="col-md-6">
                <h1 class="mb-2">Grupos principales:</h1>
                <select id="grupoMuscular" class="form-select">
                    <option value="">-- Elige una opción --</option>
                    <option value="chest">Pecho</option>
                    <option value="back">Espalda</option>
                    <option value="legs">Piernas</option>
                    <option value="arms">Brazos</option>
                    <option value="abs">Abdomen</option>
                    <option value="shoulders">Hombros</option>
                    <option value="gluteus">Glúteos</option>
                </select>
            </div>
            <div class="col-md-6">
                <h1 class="mb-2">Subgrupos:</h1>
                <select id="subGrupos" class="form-select">
                    <option value="">-- Elige una opción --</option>
                    <option value="chest">Pecho</option>
                    <option value="back">Espalda</option>
                    <option value="legs">Piernas</option>
                    <option value="arms">Brazos</option>
                    <option value="abs">Abdomen</option>
                    <option value="shoulders">Hombros</option>
                    <option value="gluteus">Glúteos</option>
                </select>
            </div>
        </div>

        <!-- Aquí se cargarán las tarjetas de ejercicios -->
        <div id="cards-container" class="row row-cols-1 row-cols-md-2 g-4"></div>
    </div>

    <!-- PANEL DERECHO -->
     
    <!-- AÑADIR IMAGEN DEL CORAZON PARA IMPLEMENTAR LA OPCION DE CARDIO DE LA API -->

    <div class="right-panel">
        <img id="muscle-image" src="<?php echo esc_url(get_template_directory_uri()); ?>/IMG/MuscleGroupBaseImageTransparentBackground.png" class="imagen-cuerpo" alt="Silueta cuerpo humanoq" usemap="#cuerpo">
        <map name="cuerpo">
            <area alt="Biceps" title="Biceps" onclick="mostrarEjercicios('upper%20arms')" coords="297,577,275,640,253,654,239,642,244,588,263,547,285,537,293,554" shape="poly">
            <area alt="Biceps" title="Biceps" onclick="mostrarEjercicios('upper%20arms')" coords="678,536,668,573,685,626,700,649,723,653,725,624,721,593,713,571,696,546" shape="poly">
            <area alt="Pecho" title="Pecho" onclick="mostrarEjercicios('chest')" coords="434,420,454,425,468,445,471,459,475,479,475,498,473,518,470,538,461,557,443,571,417,574,393,574,370,569,354,557,348,542,339,523,339,505,339,482,341,466,348,449,363,437,375,430,388,423,409,420" shape="poly">
            <area alt="Pecho" title="Pecho" onclick="mostrarEjercicios('chest')" coords="513,423,535,423,557,420,576,423,596,430,608,440,617,451,622,464,625,481,627,498,624,515,619,532,612,549,600,563,585,569,564,576,547,576,530,573,517,568,503,561,496,552,490,539,490,520,490,505,490,491,490,474,493,461,496,446,503,432" shape="poly">
            <area alt="Isquiotibiales" title="Isquiotibiales" onclick="mostrarEjercicios('lower%20legs')" coords="1523,1054,1535,1027,1553,1008,1560,1019,1560,1044,1562,1061,1562,1078,1564,1128,1562,1169,1562,1188,1563,1203,1563,1218,1567,1234,1568,1249,1570,1271,1574,1293,1577,1318,1562,1292,1553,1272,1548,1255,1541,1238,1540,1224,1534,1209,1531,1195,1531,1180,1529,1158,1528,1125,1526,1094" shape="poly">
            <area alt="Isquiotibiales" title="Isquiotibiales" onclick="mostrarEjercicios('lower%20legs')" coords="1507,1048,1514,1067,1514,1084,1516,1101,1518,1114,1519,1128,1520,1145,1521,1157,1523,1170,1523,1186,1524,1208,1524,1226,1524,1245,1524,1262,1522,1282,1521,1299,1518,1313,1514,1291,1509,1272,1507,1252,1504,1235,1502,1216,1502,1199,1497,1179,1494,1162,1490,1150,1487,1138,1484,1125,1485,1114,1485,1101,1489,1089,1492,1075,1499,1063" shape="poly">
            <area alt="Isquiotibiales" title="Isquiotibiales" onclick="mostrarEjercicios('lower%20legs')" coords="1479,1135,1480,1148,1482,1162,1484,1174,1489,1186,1490,1197,1492,1209,1497,1223,1499,1233,1499,1247,1499,1262,1499,1277,1499,1299,1504,1326,1496,1304,1492,1257,1479,1189,1475,1165" shape="poly">
            <area alt="Isquiotibiales" title="Isquiotibiales" onclick="mostrarEjercicios('lower%20legs')" coords="1370,1326,1375,1311,1380,1298,1380,1282,1383,1267,1382,1248,1382,1230,1387,1218,1390,1203,1394,1189,1397,1174,1399,1162,1395,1137,1390,1170,1383,1199,1373,1236,1373,1270,1371,1299" shape="poly">
            <area alt="Isquiotibiales" title="Isquiotibiales" onclick="mostrarEjercicios('lower%20legs')" coords="1364,1049,1376,1064,1378,1074,1383,1085,1385,1096,1386,1107,1386,1118,1390,1129,1385,1140,1381,1151,1378,1164,1376,1178,1373,1188,1371,1198,1369,1210,1369,1220,1366,1234,1364,1246,1363,1256,1363,1266,1361,1278,1359,1290,1358,1300,1354,1310,1349,1291,1349,1278,1349,1266,1347,1249,1349,1234,1349,1220,1349,1207,1347,1193,1351,1174,1351,1157,1353,1142,1354,1127,1356,1112,1356,1088,1358,1073" shape="poly">
            <area alt="Isquiotibiales" title="Isquiotibiales" onclick="mostrarEjercicios('lower%20legs')" coords="1324,1010,1331,1020,1337,1030,1344,1037,1349,1049,1349,1057,1349,1069,1347,1083,1347,1094,1346,1106,1346,1118,1346,1128,1346,1139,1346,1149,1344,1159,1344,1169,1344,1179,1342,1191,1339,1203,1337,1213,1334,1225,1327,1247,1319,1267,1310,1288,1303,1305,1295,1318,1300,1274,1307,1244,1310,1203,1310,1169,1312,1123,1310,1101,1312,1079,1312,1037,1315,1017" shape="poly">
        </map>
    </div>
</div>



<script>
    const themeToggle = document.getElementById('theme-toggle');

    // Check local storage for theme preference
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
        themeToggle.checked = true;
    }

    themeToggle.addEventListener('change', () => {
        if (themeToggle.checked) {
            document.body.classList.add('dark-mode');
            localStorage.setItem('theme', 'dark');
        } else {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('theme', 'light');
        }
    });
</script>

<?php get_footer(); ?>