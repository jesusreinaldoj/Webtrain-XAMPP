<?php get_header(); ?>

<!-- CONTENIDO PRINCIPAL -->
 <div class="theme-switch">
    <input type="checkbox" id="theme-toggle" onclick="cambiarImagen()">
    <label for="theme-toggle"></label>
    <span>Cambiar tema</span>
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
                    <option value="abs">Abdomen</option>
                    <option value="shoulders">Hombros</option>
                    <option value="glutes">Glúteos</option>
                    <option value="waist">Cintura</option>
                    <option value="neck">Cuello</option>
                </select>
            </div>
            <div class="col-md-6">
                <h1 class="mb-2">Subgrupos:</h1>
                <select id="subGrupos" class="form-select">
                    <option value="">-- Elige una opción --</option>
                    <option value="biceps">Biceps</option>
                    <option value="triceps">Triceps</option>
                    <option value="forearms">Antebrazo</option>
                    <option value="abductors">Abductores</option>
                    <option value="adductors">Adductores</option>
                    <option value="calves">Gemelos</option>
                </select>
            </div>
        </div>

        <!-- Aquí se cargarán las tarjetas de ejercicios -->
        <div id="cards-container" class="row row-cols-1 row-cols-md-2 g-4"></div>
    </div>

    <!-- PANEL DERECHO -->
    <div class="right-panel">
        <img id="muscle-image" src="<?php echo get_template_directory_uri(); ?>/IMG/MuscleGroupBaseImageTransparentBackground.png" class="imagen-cuerpo mt-5" alt="Silueta cuerpo humanoq" usemap="#cuerpo">
        <!-- Imagen corazón centrada entre las dos siluetas -->
        <img id="cardio-image" title="Cardio" src="<?php echo get_template_directory_uri(); ?>/IMG/cardio_white_theme.png" alt="Cardio" class="imagen-cardio-centro" onclick="mostrarEjerciciosPorPrincipal('cardio')">
        <!-- <img src="./IMG/MuscleGroupBaseImageTransparentBackground.png" alt="Silueta cuerpo humano" class="imagen-cuerpo" usemap="#cuerpo" /> -->
        <map name="cuerpo">
            <area alt="Cuello" title="Cuello" onclick="mostrarEjerciciosPorPrincipal('neck')" coords="441,316,441,348,445,361,378,407,399,411,423,414,439,405,463,421,472,416,478,394,456,341" shape="poly">
            <area alt="Cuello" title="Cuello" onclick="mostrarEjerciciosPorPrincipal('neck')" coords="456,326,510,326,492,367,485,385,478,383,470,358" shape="poly">
            <area alt="Cuello" title="Cuello" onclick="mostrarEjerciciosPorPrincipal('neck')" coords="527,316,527,350,526,369,539,371,559,389,590,405,573,411,541,413,537,398,519,410,505,418,517,391,505,399,498,415,492,418,490,398,500,369,509,347" shape="poly">
            <area alt="Cuello" title="Cuello" onclick="mostrarEjerciciosPorPrincipal('neck')" coords="1400,290,1427,290,1427,386,1354,386,1364,376,1380,369,1392,359,1398,339,1403,313" shape="poly">
            <area alt="Cuello" title="Cuello" onclick="mostrarEjerciciosPorPrincipal('neck')" coords="1446,291,1446,386,1520,387,1508,377,1492,367,1478,353,1469,321,1471,298,1469,289" shape="poly">
            <area alt="Abductores" title="Abductores" onclick="mostrarEjerciciosPorPrincipal('abductors')" coords="1275,978,1278,1105,1288,1181,1298,1215,1297,1156,1302,1097,1300,1039,1290,1010,1281,987" shape="poly">
            <area alt="Abductores" title="Abductores" onclick="mostrarEjerciciosPorPrincipal('abductors')" coords="1597,974,1595,1067,1590,1132,1583,1187,1575,1218,1576,1157,1569,1096,1575,1038,1583,1008,1588,991" shape="poly">
            <area alt="Adductores" title="Adductores" onclick="mostrarEjerciciosPorPrincipal('adductors')" coords="578,871,548,911,529,947,515,979,498,1023,502,1074,510,1122,524,1054,527,1030,548,969,590,869,593,859" shape="poly">
            <area alt="Adductores" title="Adductores" onclick="mostrarEjerciciosPorPrincipal('adductors')" coords="370,855,393,880,407,894,422,919,436,946,448,970,454,994,459,1010,468,1019,468,1036,461,1092,454,1124,444,1061,437,1026,412,958,400,922,370,863,370,855" shape="poly">
            <area alt="Adductores" title="Adductores" onclick="mostrarEjerciciosPorPrincipal('adductors')" coords="1378,1042,1415,1039,1422,1046,1420,1063,1414,1105,1402,1142,1403,1097,1392,1066" shape="poly">
            <area alt="Adductores" title="Adductores" onclick="mostrarEjerciciosPorPrincipal('adductors')" coords="1495,1042,1483,1059,1476,1075,1473,1086,1469,1100,1468,1117,1469,1127,1473,1146,1459,1098,1451,1053,1453,1037" shape="poly">
            <area alt="Glúteos" title="Glúteos" onclick="mostrarEjerciciosPorPrincipal('glutes')" coords="1390,843,1356,860,1315,885,1298,905,1295,926,1298,956,1314,985,1331,1007,1346,1019,1363,1022,1378,1029,1398,1031,1414,1026,1422,1016,1420,994,1429,955,1432,897,1425,866,1407,843" shape="poly">
            <area alt="Glúteos" title="Glúteos" onclick="mostrarEjerciciosPorPrincipal('glutes')" coords="1468,842,1483,842,1497,850,1524,862,1547,877,1568,894,1573,904,1576,918,1576,938,1571,960,1561,979,1542,1006,1527,1020,1510,1021,1492,1028,1471,1032,1453,1021,1451,991,1439,911,1442,877,1454,857" shape="poly">        <area alt="Antebrazo" title="Antebrazo" onclick="mostrarEjerciciosPorPrincipal('forearms')" coords="236,657,241,671,243,703,270,696,271,710,285,725,271,757,197,908,165,903,188,782,197,721,215,686" shape="poly">
            <area alt="Antebrazo" title="Antebrazo" onclick="mostrarEjerciciosPorPrincipal('forearms')" coords="726,659,746,674,763,708,770,723,775,764,800,893,797,910,770,910,722,815,680,727,688,712,698,698,722,703" shape="poly">
            <area alt="Antebrazo" title="Antebrazo" onclick="mostrarEjerciciosPorPrincipal('forearms')" coords="1183,686,1207,710,1207,729,1210,739,1229,734,1225,751,1207,791,1159,886,1146,902,1129,910,1114,903,1131,839,1149,724,1164,710,1180,739,1186,730" shape="poly">
            <area alt="Antebrazo" title="Antebrazo" onclick="mostrarEjerciciosPorPrincipal('forearms')" coords="1688,684,1663,717,1675,749,1658,735,1642,737,1666,791,1700,861,1727,911,1764,911,1744,847,1724,730,1708,706,1695,739,1685,725" shape="poly">
            <area alt="Espalda" title="Espalda" onclick="mostrarEjerciciosPorPrincipal('back')" coords="1332,426,1317,431,1295,441,1276,451,1266,485,1270,507,1271,519,1281,558,1298,599,1302,627,1324,736,1327,748,1324,756,1312,761,1305,780,1303,800,1305,822,1310,831,1331,807,1349,802,1420,848,1427,777,1430,417,1403,397,1359,395,1329,399" shape="poly">
            <area alt="Espalda" title="Espalda" onclick="mostrarEjerciciosPorPrincipal('back')" coords="1536,426,1595,453,1607,489,1602,517,1590,548,1586,575,1575,595,1549,738,1547,751,1559,758,1566,775,1568,788,1568,802,1564,831,1547,812,1520,805,1453,848,1446,777,1442,426,1458,402,1488,394,1525,395,1544,399" shape="poly">
            <area alt="Hombros" title="Hombros" onclick="mostrarEjerciciosPorPrincipal('shoulders')" coords="371,423,339,438,329,450,327,462,327,474,327,487,324,496,314,509,305,518,297,528,287,521,268,506,256,474,263,450,275,433,302,411,321,403,341,403,356,408" shape="poly">
            <area alt="Hombros" title="Hombros" onclick="mostrarEjerciciosPorPrincipal('shoulders')" coords="595,423,622,436,633,443,636,453,636,467,638,479,639,489,645,499,651,509,661,520,670,525,680,523,689,516,704,494,709,472,704,447,678,421,653,403,629,401,609,409" shape="poly">
            <area alt="Hombros" title="Hombros" onclick="mostrarEjerciciosPorPrincipal('shoulders')" coords="1303,424,1275,444,1261,466,1261,482,1258,494,1244,508,1229,518,1212,527,1212,462,1220,444,1242,420,1266,410,1286,415" shape="poly">
            <area alt="Hombros" title="Hombros" onclick="mostrarEjerciciosPorPrincipal('shoulders')" coords="1571,425,1590,437,1598,446,1605,454,1608,464,1610,476,1610,490,1617,498,1624,505,1632,512,1642,519,1654,524,1661,527,1661,468,1654,447,1642,432,1624,417,1605,412,1588,413" shape="poly">
            <area alt="Biceps" title="Biceps" onclick="mostrarEjerciciosPorPrincipal('upper%20arms')" coords="281,538,291,544,295,560,295,575,293,589,289,600,284,612,279,624,273,639,262,648,250,651,239,650,240,634,242,621,242,604,245,590,250,580,256,567,262,555,269,543" shape="poly">
            <area alt="Biceps" title="Biceps" onclick="mostrarEjerciciosPorPrincipal('upper%20arms')" coords="322,508,328,518,330,530,334,544,334,556,330,573,327,586,320,603,313,617,308,634,300,647,291,661,283,673,276,680,269,681,266,668,278,646,284,630,291,612,298,598,303,576,312,551" shape="poly">
            <area alt="Biceps" title="Biceps" onclick="mostrarEjerciciosPorPrincipal('upper%20arms')" coords="724,649,724,629,724,612,720,598,717,583,713,575,708,564,702,552,693,542,683,537,674,546,671,559,669,569,669,583,673,593,676,605,680,617,686,627,693,639,700,646,708,651,715,654" shape="poly">
            <area alt="Biceps" title="Biceps" onclick="mostrarEjerciciosPorPrincipal('upper%20arms')" coords="700,671,697,680,685,678,674,666,669,654,659,641,656,629,652,620,647,608,642,593,639,581,635,569,632,552,634,539,635,529,639,520,642,510,651,539,652,549,658,566,663,580,669,600" shape="poly">
            <area alt="Triceps" title="triceps" onclick="mostrarEjerciciosPorPrincipal('triceps')" coords="1258,505,1268,559,1239,581,1229,591,1221,600,1219,591,1216,579,1216,566,1217,554,1221,544,1228,533" shape="poly">
            <area alt="Triceps" title="triceps" onclick="mostrarEjerciciosPorPrincipal('triceps')" coords="1204,583,1212,598,1217,610,1221,620,1219,637,1200,688,1192,679,1192,667,1192,656,1192,642,1194,630,1197,615" shape="poly">
            <area alt="Triceps" title="triceps" onclick="mostrarEjerciciosPorPrincipal('triceps')" coords="1221,708,1229,698,1238,689,1241,678,1243,666,1243,659,1251,650,1258,640,1261,628,1265,618,1268,606,1273,596,1273,584,1273,572,1270,564,1258,576,1250,583,1241,591,1233,600,1229,611,1229,622,1228,635,1224,645,1224,659,1221,671,1217,684,1217,695" shape="poly">
            <area alt="Triceps" title="triceps" onclick="mostrarEjerciciosPorPrincipal('triceps')" coords="1613,506,1604,559,1613,566,1623,571,1633,578,1638,586,1645,594,1652,598,1655,588,1658,576,1657,564,1657,554,1653,545,1645,532,1638,525" shape="poly">
            <area alt="Triceps" title="triceps" onclick="mostrarEjerciciosPorPrincipal('triceps')" coords="1669,583,1680,635,1680,650,1682,666,1679,684,1672,689,1669,678,1665,667,1660,654,1657,644,1653,633,1652,622,1655,613,1660,601" shape="poly">
            <area alt="Triceps" title="triceps" onclick="mostrarEjerciciosPorPrincipal('triceps')" coords="1602,567,1641,601,1645,610,1645,620,1647,635,1648,647,1650,661,1653,671,1655,683,1655,695,1653,706,1652,710,1643,701,1636,691,1633,681,1633,667,1624,652,1618,644,1613,635,1611,623,1607,613,1602,601,1601,591,1601,579" shape="poly">
            <area alt="Abdominales" title="Abdominales" onclick="mostrarEjerciciosPorPrincipal('abs')" coords="464,569,469,571,475,578,475,589,477,600,477,611,475,622,465,632,453,639,443,644,435,650,425,657,413,661,411,647,408,633,407,618,408,608,411,594,423,591,436,584,448,576,464,569,456,571" shape="poly">
            <area alt="Abdominales" title="Abdominales" onclick="mostrarEjerciciosPorPrincipal('abs')" coords="490,627,500,630,510,639,520,642,529,649,539,654,551,662,556,652,559,639,559,628,558,617,558,606,554,594,544,588,534,584,524,579,513,574,502,569,495,571,490,581" shape="poly">
            <area alt="Abdominales" title="Abdominales" onclick="mostrarEjerciciosPorPrincipal('abs')" coords="553,701,553,688,549,678,546,669,534,662,524,656,513,650,503,644,495,640,488,647,488,656,488,667,488,681,488,691,488,700,493,705,503,706,513,706,525,706,537,708,547,706" shape="poly">
            <area alt="Abdominales" title="Abdominales" onclick="mostrarEjerciciosPorPrincipal('abs')" coords="412,705,422,706,432,705,442,706,452,706,463,706,473,705,476,698,476,688,476,678,476,666,476,654,478,644,468,640,459,647,449,650,441,656,429,662,420,669,413,679" shape="poly">
            <area alt="Abdominales" title="Abdominales" onclick="mostrarEjerciciosPorPrincipal('abs')" coords="488,712,498,712,508,712,519,713,530,717,541,718,554,720,554,730,556,744,554,756,549,766,536,767,522,767,513,766,500,766,490,764,488,749,488,735,486,723" shape="poly">
            <area alt="Abdominales" title="Abdominales" onclick="mostrarEjerciciosPorPrincipal('abs')" coords="412,720,422,718,432,717,442,713,454,713,464,713,476,712,478,722,478,735,478,744,476,756,476,766,464,767,454,767,442,766,432,766,422,766,413,762,410,749,410,739,410,732" shape="poly">
            <area alt="Abdominales" title="Abdominales" onclick="mostrarEjerciciosPorPrincipal('abs')" coords="486,779,497,776,507,776,517,776,530,776,539,774,549,774,553,783,553,793,549,805,549,817,547,830,544,842,542,854,541,866,539,878,536,888,532,901,529,910,524,920,519,929,510,937,503,942,495,947,488,947" shape="poly">
            <area alt="Abdominales" title="Abdominales" onclick="mostrarEjerciciosPorPrincipal('abs')" coords="476,949,478,779,466,776,451,776,439,776,422,774,412,776,413,788,415,801,415,813,417,825,419,839,422,854,425,868,427,883,432,896,439,912,442,924,449,934,458,942,468,946,476,949" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="350,1289,354,1304,381,1468,387,1508,389,1528,391,1584,387,1594,377,1569,371,1553,365,1532,361,1516,356,1499,354,1479,350,1454,348,1435,346,1413,346,1386,344,1363,346,1343" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="361,1631,369,1619,373,1602,371,1586,367,1563,363,1549,358,1534,354,1516,350,1499,346,1481,342,1462,340,1448,340,1431,338,1411,338,1392,338,1376,342,1335,338,1349,334,1372,332,1421,334,1481,342,1526,352,1573,358,1598" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="418,1359,428,1442,428,1462,426,1479,422,1493,416,1508,414,1520,402,1573,396,1495,389,1429,389,1417,400,1396" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="622,1337,628,1347,630,1367,630,1380,632,1405,630,1487,618,1551,606,1602,606,1631,593,1611,593,1588,599,1557,612,1512,622,1454,626,1417" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="616,1289,622,1405,614,1462,606,1510,589,1565,577,1592,573,1586,573,1561,575,1518,585,1450,612,1300" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="546,1359,573,1411,575,1421,575,1438,564,1571,548,1506,538,1481,536,1450" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="1339,1289,1339,1343,1341,1361,1339,1512,1343,1524,1353,1522,1364,1512,1376,1491,1382,1464,1382,1419,1374,1370,1360,1332" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="1331,1287,1327,1508,1318,1522,1306,1526,1296,1514,1292,1495,1288,1473,1285,1454,1285,1433,1285,1413,1285,1392,1290,1372,1294,1353,1300,1335" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="1343,1709,1351,1654,1358,1623,1360,1600,1362,1573,1364,1553,1353,1545,1343,1545,1339,1571,1343,1693" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="1298,1549,1308,1541,1321,1541,1327,1553,1329,1580,1333,1644,1335,1685,1329,1712,1316,1635,1310,1582" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="1529,1707,1522,1660,1516,1625,1512,1596,1512,1578,1510,1561,1512,1549,1522,1543,1533,1547,1533,1625,1533,1660" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="1545,1709,1555,1644,1564,1578,1574,1549,1564,1541,1551,1543,1545,1555,1543,1594,1541,1635,1539,1679,1541,1697" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="1541,1289,1547,1382,1549,1475,1547,1497,1547,1516,1555,1524,1570,1524,1576,1514,1582,1489,1586,1446,1586,1396,1578,1343,1562,1316" shape="poly">
            <area alt="Gemelos" title="Gemelos" onclick="mostrarEjerciciosPorPrincipal('calves')" coords="1533,1289,1533,1351,1531,1388,1533,1489,1533,1518,1529,1526,1516,1520,1504,1503,1494,1485,1489,1452,1496,1394,1502,1359,1518,1326" shape="poly">
            <area alt="Pecho" title="Pecho" onclick="mostrarEjerciciosPorPrincipal('chest')" coords="434,420,454,425,468,445,471,459,475,479,475,498,473,518,470,538,461,557,443,571,417,574,393,574,370,569,354,557,348,542,339,523,339,505,339,482,341,466,348,449,363,437,375,430,388,423,409,420" shape="poly">
            <area alt="Pecho" title="Pecho" onclick="mostrarEjerciciosPorPrincipal('chest')" coords="513,423,535,423,557,420,576,423,596,430,608,440,617,451,622,464,625,481,627,498,624,515,619,532,612,549,600,563,585,569,564,576,547,576,530,573,517,568,503,561,496,552,490,539,490,520,490,505,490,491,490,474,493,461,496,446,503,432" shape="poly">
            <area alt="Isquiotibiales" title="Isquiotibiales" onclick="mostrarEjerciciosPorPrincipal('lower%20legs')" coords="1523,1054,1535,1027,1553,1008,1560,1019,1560,1044,1562,1061,1562,1078,1564,1128,1562,1169,1562,1188,1563,1203,1563,1218,1567,1234,1568,1249,1570,1271,1574,1293,1577,1318,1562,1292,1553,1272,1548,1255,1541,1238,1540,1224,1534,1209,1531,1195,1531,1180,1529,1158,1528,1125,1526,1094" shape="poly">
            <area alt="Isquiotibiales" title="Isquiotibiales" onclick="mostrarEjerciciosPorPrincipal('lower%20legs')" coords="1507,1048,1514,1067,1514,1084,1516,1101,1518,1114,1519,1128,1520,1145,1521,1157,1523,1170,1523,1186,1524,1208,1524,1226,1524,1245,1524,1262,1522,1282,1521,1299,1518,1313,1514,1291,1509,1272,1507,1252,1504,1235,1502,1216,1502,1199,1497,1179,1494,1162,1490,1150,1487,1138,1484,1125,1485,1114,1485,1101,1489,1089,1492,1075,1499,1063" shape="poly">
            <area alt="Isquiotibiales" title="Isquiotibiales" onclick="mostrarEjerciciosPorPrincipal('lower%20legs')" coords="1364,1049,1376,1064,1378,1074,1383,1085,1385,1096,1386,1107,1386,1118,1390,1129,1385,1140,1381,1151,1378,1164,1376,1178,1373,1188,1371,1198,1369,1210,1369,1220,1366,1234,1364,1246,1363,1256,1363,1266,1361,1278,1359,1290,1358,1300,1354,1310,1349,1291,1349,1278,1349,1266,1347,1249,1349,1234,1349,1220,1349,1207,1347,1193,1351,1174,1351,1157,1353,1142,1354,1127,1356,1112,1356,1088,1358,1073" shape="poly">
            <area alt="Isquiotibiales" title="Isquiotibiales" onclick="mostrarEjerciciosPorPrincipal('lower%20legs')" coords="1324,1010,1331,1020,1337,1030,1344,1037,1349,1049,1349,1057,1349,1069,1347,1083,1347,1094,1346,1106,1346,1118,1346,1128,1346,1139,1346,1149,1344,1159,1344,1169,1344,1179,1342,1191,1339,1203,1337,1213,1334,1225,1327,1247,1319,1267,1310,1288,1303,1305,1295,1318,1300,1274,1307,1244,1310,1203,1310,1169,1312,1123,1310,1101,1312,1079,1312,1037,1315,1017" shape="poly">
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

    function cambiarImagen() {
        const cardioImage = document.getElementById('cardio-image');
        if (themeToggle.checked) {
            cardioImage.src = '<?php echo get_template_directory_uri(); ?>/IMG/cardio_black_theme.png';
        } else {
            cardioImage.src = '<?php echo get_template_directory_uri(); ?>/IMG/cardio_white_theme.png';
        }
    }

    function setCardioImageByTheme() {
        const cardioImg = document.getElementById('cardio-image');
        if (!cardioImg) return;
        if (document.body.classList.contains('dark-mode')) {
            cardioImg.src = '<?php echo get_template_directory_uri(); ?>/IMG/cardio_black_theme.png';
        } else {
            cardioImg.src = '<?php echo get_template_directory_uri(); ?>/IMG/cardio_white_theme.png';
        }
    }
    // Llama la función al cargar la página
    setCardioImageByTheme();
    // Llama la función cada vez que se cambia el tema
    themeToggle = document.getElementById('theme-toggle');
    themeToggle.addEventListener('change', setCardioImageByTheme);
</script>

<?php get_footer(); ?>
