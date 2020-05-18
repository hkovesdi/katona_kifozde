@extends('app') @section('content')

<body>
    <nav class="topnav">
        <ul>
            <li><a class="active" href="#home">Főoldal</a></li>
            <li onclick="myFunction()" class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Futárok</a>
                <div id="myDropdown" class="dropdown-content">
                    <a href="#1">Futar1</a>
                    <a href="#2">Futar2</a>
                    <a href="#3">Futar3</a>
                    <a href="#4">Futar4</a>
                    <a href="#5">Futar5</a>
                    <a href="#6">Futar6</a>
                    <a href="#7">Futar7</a>
                </div>
            </li>
            <li><a href="#diagrams">Diagramok</a></li>
            <li class="right"><a href="#logout">Kijelentkezés</a></li>
        </ul>
    </nav>
    <div class="flex-center">
    <table role="table" class="maintable">
        <thead role="rowgroup">
            <tr role="row">
                <th role="columnheader" class="fejlec-center">ID</th>
                <th role="columnheader" class="fejlec-center">Név</th>
                <th role="columnheader" class="fejlec-center">Cim</th>
                <th role="columnheader" class="fejlec-center">Tel</th>
                <th role="columnheader" class="fejlec-center">Fizetési mód</th>
                <th role="columnheader" class="fejlec-center">Összeg</th>
                <th role="columnheader" class="fejlec-center">Fizetett</th>
            </tr>
        </thead>
        <tbody role="rowgroup">
            <tr role="row">
                <td role="cell" class="centercell">1
                    <button id="menusorbtn" class="menubtn">Menüsor</button>
                </td>
                <td role="cell" id="name">Katona Bence</td>
                <td role="cell">Cegléd, Csengeri szél 46.</td>
                <td role="cell">+36309737274</td>
                <td role="cell" class="centercell">
                    <select>
                        <option value="KP">Készpénz</option>
                        <option value="BK">Bankkártya</option>
                        <option value="SZK">Szépkártya</option>
                        <option value="BP">Baptista</option>
                    </select>
                </td>
                <td role="cell" class="centercell">
                    15000Ft
                </td>
                <td role="cell" class="centercell">
                    <button type="submit" class="fizetve-button buttonhover">Fizetve</button>
                </td>
            </tr>

            <tr role="row">
                <td role="cell" class="centercell">2
                    <button id="menusorbtn" class="menubtn">Menüsor</button>
                </td>
                <td role="cell" id="name">Tóth Zsombor Gábor</td>
                <td role="cell">Miskolc, Világ vége utca 26.</td>
                <td role="cell">+36704657876</td>
                <td role="cell" class="centercell">
                    <select>
                        <option value="KP">Készpénz</option>
                        <option value="BK">Bankkártya</option>
                        <option value="SZK">Szépkártya</option>
                        <option value="BP">Baptista</option>
                    </select>
                </td>
                <td role="cell" class="centercell">
                    3600Ft
                </td>
                <td role="cell" class="centercell">
                <button type="submit" class="fizetve-button buttonhover">Fizetve</button>
                </td>
            </tr>

            <tr role="row">
                <td role="cell" class="centercell">3
                    <button id="menusorbtn" class="menubtn">Menüsor</button>
                </td>
                <td role="cell" id="name">Kövesdi Hunor</td>
                <td role="cell">TSZMárton, Halál fasza 12 3.Em 14cs</td>
                <td role="cell">+36209987657</td>
                <td role="cell" class="centercell">
                    <select>
                        <option value="KP">Készpénz</option>
                        <option value="BK">Bankkártya</option>
                        <option value="SZK">Szépkártya</option>
                        <option value="BP">Baptista</option>
                    </select>
                </td>
                <td role="cell" class="centercell">
                    5200Ft
                </td>
                <td role="cell" class="centercell">
                    <button type="submit" class="fizetve-button buttonhover">Fizetve</button>
                </td>

                <table id="myTable" style="display: none">
                    <tr>
                        <td>21. hét</td>
                        <td>A Menü</td>
                        <td>B Menü</td>
                        <td>Leves</td>
                        <td>A második</td>
                        <td>B második</td>
                        <td>Takarék menü</td>
                        <td>Doboz</td>
                        <td>A1</td>
                        <td>A2</td>
                        <td>A3</td>
                        <td>A4</td>
                        <td>A5</td>
                        <td>S1</td>
                        <td>S2</td>
                        <td>S3</td>
                        <td>S4</td>
                    </tr>

                    <tr>
                        <td>Hétfő</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Kedd</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Szerda</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Csütörtök</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Péntek</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
         
                </table>

            </tr>

        </tbody>
    </table>

</div>
</body>
