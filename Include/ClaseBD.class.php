<?php
/********************************************************************
 * Archivo con la definición de la clase BaseDeDatos con sus funciones para manipulación en la db
 * Creado por Hernández Hernández Franco Salvador
 * 02 Abril 2018
 *******************************************************************/

class DBUser
{
    private $db;
    private $table;
    public function __construct($tab)
    {
        $this->db = new mysqli('localhost', 'root', '', 'User');

        if ($this->db->connect_errno) {
            printf('Falló la conexión con MySQL. Error: ' . $this->db->connect_error);
        } else {
            $this->table = $tab;
            $this->db->set_charset('UTF-8');
        }
    }
    public function Close()
    {
        $this->db->close();
    }
    public function SearchUser($nick, $pass)
    {
        if ($this->table == 'Administrator') {
            $query = "SELECT ID FROM " . $this->table . " WHERE Nickname = '" . $nick . "' AND Password = '" . $pass . "'";
        } else {
            $query = "SELECT ID, Wallet FROM " . $this->table . " WHERE Nickname = '" . $nick . "' AND Password = '" . $pass . "'";

        }
        $result = $this->db->query($query);

        if (!$result->num_rows) {
            $result->close();
            return 0;
        } else {
            $val = $result->fetch_row();
            $result->close();
            return $val;
        }
    }
    public function SignUser($nick, $pass)
    {
        $query  = "INSERT INTO " . $this->table . " (Nickname, Password) VALUES ('" . $nick . "', '" . $pass . "');";
        $result = $this->db->query($query);

        if ($this->db->errno) {
            return false;
        } else {
            return true;
        }
    }
    public function UpdateWallet($sal)
    {
        $query  = "UPDATE Customer SET Wallet = $Sal WHERE ID = '" . $_SESSION['id'] . "'";
        $result = $this->db->query($query);
    }
}

class DBShop
{
    private $db;
    private $table;
    public function __construct()
    {
        if ($this->db = new mysqli('localhost', 'root', '', 'Shop'))
        {
            ;
        } else {
                $this->db = new mysqli('localhost', '', '', 'Shop');
        }

        if ($this->db->connect_errno) {
            printf('Falló la conexión con MySQL. Error: ' . $this->db->connect_error);
        } else {
            if (count(func_get_args()) == 1) {
                $this->table = func_get_args()[0];
            } else {
                $this->table = '';
            }
            $this->db->set_charset('UTF-8');
        }
    }
    public function Close()
    {
        $this->db->close();
    }
    public function GetSectName($ID)
    {
        $query  = "SELECT SectionName FROM Section WHERE SectionID = " . $ID;
        $result = $this->db->query($query);

        $name = $result->fetch_row()[0];
        $result->close();
        return $name;
    }
    public function GetSections()
    {
        $query  = "SELECT * FROM Section ORDER BY SectionName";
        $result = $this->db->query($query);

        while ($row = $result->fetch_row()) {
            $sections[] = array(
                'SectID'   => $row[0],
                'SectName' => $row[1],
            );
        }
        $result->close();
        return $sections;
    }
    public function GetArticles($id)
    {
        $query  = "SELECT A.Name, A.MadeBy, A.Image, A.Description, A.ID FROM Section S INNER JOIN Article A ON S.SectionID = A.SectionID WHERE S.SectionID = " . $id . " ORDER BY Name";
        $result = $this->db->query($query);

        if (!$result->num_rows) {
            $result->close();
            return 0;
        } else {
            while ($row = $result->fetch_row()) {
                $arts[] = array(
                    'Name'        => $row[0],
                    'MadeBy'      => $row[1],
                    'Image'       => $row[2],
                    'Description' => $row[3],
                    'ID'          => $row[4],
                );
            }
            $result->close();
            return $arts;
        }

    }
    public function GetArticleDetails($ID)
    {
        $search = "SELECT Name, MadeBy, Description, Image, Price, Stock FROM Article WHERE ID = '" . $ID . "'";
        $result = $this->db->query($search);

        $row = $result->fetch_row();
        $det = array(
            'Name'        => $row[0],
            'MadeBy'      => $row[1],
            'Description' => $row[2],
            'Image'       => $row[3],
            'Price'       => $row[4],
            'Stock'       => $row[5],
        );
        $result->close();
        return $det;
    }
    public function GetArticleDetailsToCar($ID)
    {
        $search = "SELECT Name, Image, Price, Stock FROM Article WHERE ID = '" . $ID . "'";
        $result = $this->db->query($search);

        $row = $result->fetch_row();
        $det = array(
            'Name'     => $row[0],
            'Image'    => $row[1],
            'Price'    => (float) $row[2],
            'Stock'    => $row[3],
            'Quantity' => 1,
            'ID'       => $ID,
        );
        $result->close();
        return $det;
    }
    public function CreateTicket()
    {
        $query  = "INSERT INTO Ticket (Total, UserID) VALUES ('" . $_SESSION['total'] . "', '" . $_SESSION['id'] . "');";
        $result = $this->db->query($query);

        $query  = "SELECT LAST_INSERT_ID()";
        $result = $this->db->query($query);
        $id     = $result->fetch_row()[0];
        $result->close();
        return $id;
    }
    public function InsertArticlesBought($artID, $name, $quant, $subt, $tickID)
    {
        $query  = "INSERT INTO ArticleBought (ID, Name, Quantity, Subtotal, TicketID) VALUES ('$artID', '$name', $quant, $subt, '$tickID')";
        $result = $this->db->query($query);
    }
    public function UpdateStock($ID, $Stock)
    {
        $query  = "UPDATE Article SET Stock = '" . $Stock . "' WHERE ID = '" . $ID . "';";
        $result = $this->db->query($query);
    }
    public function UpdateWallet()
    {
        $query  = "UPDATE User.Customer SET Wallet = '" . $_SESSION['Wallet'] . "' WHERE ID = '" . $_SESSION['id'] . "'";
        $result = $this->db->query($query);
    }
    public function InfoTicket($ID)
    {
        $query  = "SELECT T.TicketID, T.Total, T.DateTicket, A.ID, A.Name, A.Subtotal, A.Quantity FROM Ticket T INNER JOIN ArticleBought A ON T.TicketID = A.TicketID WHERE T.TicketID = '$ID'";
        $result = $this->db->query($query);
        while ($row = $result->fetch_row()) {
            $ret[] = $row;
        }
        $result->close();
        return $ret;
    }
    public function GetTickets()
    {
        $query  = "SELECT TicketID, Total, DateTicket From Ticket WHERE UserID = " . $_SESSION['id'];
        $result = $this->db->query($query);
        if ($result->num_rows) {
            while ($row = $result->fetch_row()) {
                $ret[] = $row;
                var_dump($row);
            }
            $result->close();
            return $ret;
        } else {
            return false;
        }
    }
    public function GetResult($search)
    {
        $query  = "SELECT A.ID, A.Name, S.SectionName, A.Price, A.Stock FROM Article A INNER JOIN  Section S ON S.SectionID = A.SectionID WHERE A.Name LIKE '%" . $search . "%' ORDER BY A.Name";
        $result = $this->db->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_row()) {
                $ret[] = $row;
            }
            return $ret;
        } else {
            return "No se encontraron coincidencias";
        }
    }
    public function DeleteArticle($ID)
    {
        $query  = "DELETE FROM Article WHERE ID = '" . $ID . "'";
        $result = $this->db->query($query);
        if ($result) {
            echo '<h4 class="text-center">Se eliminó correctamente</ha>';
        } else {
            echo '<h4 class="text-center">Hubo un problema al eliminar el producto</h4>';
        }
    }
    public function InsertArticle($ID, $Name, $MadeBy, $Image, $Description, $Price, $Stock, $Section)
    {
        $query  = "INSERT INTO Article (ID, Name, MadeBy, Image, Description, Price, Stock, SectionID) VALUES ('$ID', '$Name', '$MadeBy', '$Image', '$Description', '$Price', '$Stock', '$Section')";
        $result = $this->db->query($query);
    }
    public function GetImg()
    {
        $query  = "SELECT Image FROM Article LIMIT 5";
        $result = $this->db->query($query);
        while ($row = $result->fetch_row()) {
            $ret[] = $row;
        }
        return $ret;
    }
}
