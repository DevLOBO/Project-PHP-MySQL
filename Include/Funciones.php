<?php
require_once 'ClaseBD.class.php';
function SearchUser($type, $nick, $pass)
{
    $BD   = new DBUser($type);
    $user = $BD->SearchUser($nick, $pass);
    $BD->Close();
    return $user;
}
function SignUser($type, $nick, $pass)
{
    $BD = new DBUser($type);
    $S  = $BD->SignUser($nick, $pass);
    $BD->Close();
    return $S;
}
function DisplaySections()
{
    $BD       = new DBShop;
    $sections = $BD->GetSections();
    $BD->Close();

    print('<nav id="sections" class="nav nav-pills flex-column nav-justified">
        <a class="nav-item nav-link active" href="index.php"><span class="icon-home"></span></a>
    ');
    foreach ($sections as $sec) {
        print('<a href="showCat.php?sectID=' . $sec['SectID'] . '" class="nav-item nav-link">' . $sec['SectName'] . '</a>');
    }
    print('</nav>');
}
function SetSectionDetails($ID)
{
    $BD                   = new DBShop;
    $sectName             = $BD->GetSectName($ID);
    $_SESSION['Sección'] = ['ID' => $ID, 'SectName' => $BD->GetSectName($ID)];
    $BD->Close();
}
function GetCatalogue($ID)
{
    $BD       = new DBShop;
    $articles = $BD->GetArticles($ID);
    $BD->Close();
    return $articles;
}
function GetArticle($ArtID)
{
    $BD      = new DBShop('Article');
    $details = $BD->GetArticleDetails($ArtID);
    $BD->Close();
    return $details;
}
function ArticleExists($ID)
{
    foreach ($_SESSION['Cart'] as $clave => $art) {
        if ($art['ID'] == $ID) {
            return $clave;
        } else {
            return 0;
        }
    }
}
function CalculateTotalItems()
{
    $total = 0;
    $items = 0;
    foreach ($_SESSION['Cart'] as $art) {
        $total += $art['Price'] * $art['Quantity'];
        $items += $art['Quantity'];

    }
    $_SESSION['items'] = $items;
    $_SESSION['total'] = $total;
}
function AddToCar($ID, $Quant)
{
    $BD              = new DBShop;
    $art             = $BD->GetArticleDetailsToCar($ID);
    $art['Quantity'] = $Quant;

    if (!empty($_SESSION['Cart'])) {
        if ($ret = ArticleExists($ID)) {
            $_SESSION['Cart'][$ret]['Quantity'] += $Quant;
        } else {
            array_push($_SESSION['Cart'], $art);
        }
    } else {
        $_SESSION['Cart'][1] = $art;
    }
    $BD->Close();
}
function CancelArticle($Art)
{
    for ($i = 0; $i < count($Art); $i++) {
        foreach ($_SESSION['Cart'] as $clave => $pro) {
            if ($pro['ID'] == $Art[$i]) {
                unset($_SESSION['Cart'][$clave]);
                break;
            }
        }
    }
}
function DisplayCar()
{
    if (isset($_SESSION['Cart']) and count($_SESSION['Cart']) != 0) {
        print('
                <table>
                    <tr>
                        <th colspan="2">Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
            ');
        foreach ($_SESSION['Cart'] as $art) {
            print('<form action="showCar.php" method="POST">
                <tr>
                    <td><input type="checkbox" name="CancelArt[]" value="' . $art["ID"] . '"></td>
                    <td>' . $art["Name"] . '</td>
                    <td>$' . $art["Price"] . '</td>
                    <td>' . $art["Quantity"] . '</td>
                    <td>$' . ($art["Quantity"] * $art["Price"]) . '</td>
                </tr>
            ');
        }
        print('
            </table>
            <button type="submit" name="Cancel">Cancelar producto(s)</button>
            <a href="index.php">Seguir comprando</a>
            <a href="buy.php">Comprar</a>
            </form>
        ');
        CalculateTotalItems();
    } else {
        print('<span>No has añadido ningún producto</span>');
    }
}
function ErrorBuy()
{
    $ret = false;

    if ($_SESSION['Wallet'] > $_SESSION['total']) {
        foreach ($_SESSION['Cart'] as $pro) {
            if ($pro['Quantity'] > $pro['Stock']) {
                $ret['Articles'][] = $pro['Name'];
                $ret['Message']    = 'no hay suficientes existencias';

            }
        }
    } else {
        $ret['Message'] = 'no tienes suficiente crédito';
    }
    return $ret;
}
function CreateTicket()
{
    $BD     = new DBShop;
    $ticket = $BD->CreateTicket();
    foreach ($_SESSION['Cart'] as $pro) {
        $BD->InsertArticlesBought($pro['ID'], $pro['Name'], $pro['Quantity'], ($pro['Quantity'] * $pro['Price']), $ticket);
        $pro['Stock'] -= $pro['Quantity'];
        $BD->UpdateStock($pro['ID'], $pro['Stock']);
    }
    $_SESSION['Wallet'] -= $_SESSION['total'];
    $BD->UpdateWallet();
    $info = $BD->InfoTicket($ticket);
    $BD->Close();
    unset($_SESSION['Cart']);
    $_SESSION['total'] = 0;
    $_SESSION['items'] = 0;
    return $info;
}
function UpdateWallet($sal)
{
    $BD = new DBUser($_SESSION['tipo']);
    $BD->UpdateWallet($sal);
    $BD->Close();
    $_SESSION['Wallet'] = $sal;
}
function GetTickets()
{
    $BD   = new DBShop;
    $info = $BD->GetTickets();
    $BD->Close();
    return $info;
}
function GetResult($search)
{
    $BD     = new DBShop;
    $result = $BD->GetResult($search);
    $BD->Close();

    if (gettype($result) != "string") {
        print('
            <table id="data-table" class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Sección</th>
                    <th>Precio</th>
                    <th>Existencias</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
            ');
        foreach ($result as $res) {
            print('
                <tr id="' . $res[0] . '">
                    <td>' . $res[0] . '</td>
                    <td>' . $res[1] . '</td>
                    <td>' . $res[2] . '</td>
                    <td>$' . $res[3] . '</td>
                    <td>' . $res[4] . '</td>
                    <td><div class="btn-group btn-group-sm"><button class="btn btn-info edit" type="button"><span class="icon-pencil"></span></button><button class="btn btn-danger delete" type="button" data-toggle="modal"><span class="icon-bin" ></span></button></div></td>
                </tr>
            ');
        }
        print('
            </tbody>
            </table>
        ');
    } else {
        echo '<h3 class="text-center">' . $result . '</h3>';
    }
}
function DeleteArticle($ID)
{
    $BD = new DBShop;
    $BD->DeleteArticle($ID);
    $BD->Close();
}
function UpdateStock($ID, $Stock)
{
    $BD = new DBShop;
    $BD->UpdateStock($ID, $Stock);
    $BD->Close();
}
function GetSections()
{
    $BD   = new DBShop;
    $sect = $BD->GetSections();
    $BD->Close();
    return $sect;
}
function InsertArticle($ID, $Name, $MadeBy, $Image, $Description, $Price, $Stock, $Section) {
    $BD = new DBSHop;
    $BD->InsertArticle($ID, $Name, $MadeBy, $Image, $Description, $Price, $Stock, $Section);
    $BD->Close();
}
function DisplaySlideshow() {
    $BD = new DBShop;
    $img = $BD->GetImg();
    $BD->Close();
    print('
        <div align="center" class="carousel slide" id="Presentation" data-ride="carousel">
            <ul class="carousel-indicators">
                <li data-target="#Presentation" data-slide-to="0"></li>
                <li data-target="#Presentation" data-slide-to="1"></li>
                <li data-target="#Presentation" data-slide-to="2"></li>
                <li data-target="#Presentation" data-slide-to="3"></li>
                <li data-target="#Presentation" data-slide-to="4"></li>
            </ul>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img style="width:400px;height:auto" src="' . $img[0][0] . '" alt="" class="d-block">
                </div>
                <div class="carousel-item">
                    <img style="width:400px;height:auto" src="' . $img[1][0] . '" alt="" class="d-block">
                </div>
                <div class="carousel-item">
                    <img style="width:400px;height:auto" src="' . $img[2][0] . '" alt="" class="d-block">
                </div>
                <div class="carousel-item">
                    <img style="width:400px;height:auto" src="' . $img[3][0] . '" alt="" class="d-block">
                </div>
                <div class="carousel-item">
                    <img style="width:400px;height:auto" src="' . $img[4][0] . '" alt="" class="d-block">
                </div>
            </div>
        </div>
    ');
}