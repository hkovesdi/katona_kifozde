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
    <table role="table">
        <thead role="rowgroup">
            <tr role="row">
                <th role="columnheader" class="fejlec-center">ID</th>
                <th role="columnheader" class="fejlec-center">Név</th>
                <th role="columnheader" class="fejlec-center">Cim</th>
                <th role="columnheader" class="fejlec-center">Tel</th>
                <th role="columnheader" class="fejlec-center">Készpénz</th>
                <th role="columnheader" class="fejlec-center">Bankkártya</th>
                <th role="columnheader" class="fejlec-center">Szépkártya</th>
                <th role="columnheader" class="fejlec-center">Baptista</th>
                <th role="columnheader" class="fejlec-center">Tartozás</th>
                <th role="columnheader" class="fejlec-center">Fizetett</th>
            </tr>
        </thead>
        <tbody role="rowgroup">
            <tr role="row">
                <td role="cell" class="centercell">1</td>
                <td role="cell">Katona Bence</td>
                <td role="cell">Cegléd, Csengeri szél 46.</td>
                <td role="cell">+36309737274</td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="KP" id="check1" >
                    <label class="layout" for="check1"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="BK" id="check2" >
                    <label class="layout" for="check2"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="SZK" id="check3" >
                    <label class="layout" for="check3"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="BAP" id="check4" >
                    <label class="layout" for="check4"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="TART" id="check5" >
                    <label class="layout" for="check5"></label>
                </td>
                <td role="cell" class="centercell">
                <button type="submit" class="fizetve-button buttonhover">Fizetve</button>
                </td>
            </tr>

            <tr role="row">
                <td role="cell" class="centercell">2</td>
                <td role="cell">Tóth Zsombor Gábor</td>
                <td role="cell">Miskolc, Világ vége utca 26.</td>
                <td role="cell">+36704657876</td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="KP" id="check1" >
                    <label class="layout" for="check1"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="BK" id="check2" >
                    <label class="layout" for="check2"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="SZK" id="check3" >
                    <label class="layout" for="check3"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="BAP" id="check3" >
                    <label class="layout" for="check3"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="TART" id="check3" >
                    <label class="layout" for="check3"></label>
                </td>
                <td role="cell" class="centercell">
                <button type="submit" class="fizetve-button buttonhover">Fizetve</button>
                </td>
            </tr>

            <tr role="row">
                <td role="cell" class="centercell">3</td>
                <td role="cell">Kövesdi Hunor</td>
                <td role="cell">Tápiószentmárton, Halál fasza 12 3.Em 14cs</td>
                <td role="cell">+369987657</td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="KP" id="check1" >
                    <label class="layout" for="check1"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="BK" id="check2" >
                    <label class="layout" for="check2"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="SZK" id="check3" >
                    <label class="layout" for="check3"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="BAP" id="check3" >
                    <label class="layout" for="check3"></label>
                </td>
                <td role="cell" class="centercell">
                    <input type="checkbox" class="check" name="TART" id="check3" >
                    <label class="layout" for="check3"></label>
                </td>
                <td role="cell" class="centercell">
                <button type="submit" class="fizetve-button buttonhover">Fizetve</button>
                </td>

            </tr>
        </tbody>
    </table>
</div>
</body>
