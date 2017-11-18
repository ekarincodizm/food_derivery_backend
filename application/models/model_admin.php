<?php

class model_admin extends Model
{
    public function create_new_menu($data) {
        if (!($stmt = $this->conn->prepare("INSERT INTO menu (menu_id, menu_name_th, menu_name_en, menu_url) VALUES (?, ?, ?, ?)"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->bind_param("ssss",
            $data['id'],
            $data['name_th'],
            $data['name_en'],
            $data['url']
        )) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" .  $this->conn->error;
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $this->conn->close();
    }

    public function update_menu($data) {
        if (!($stmt = $this->conn->prepare("UPDATE menu SET menu_name_th = ?, menu_name_en = ?, menu_url = ? WHERE menu_id = ?"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->bind_param("ssss",
            $data['name_th'],
            $data['name_en'],
            $data['url'],
            $data['id']
        )) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" .  $this->conn->error;
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $this->conn->close();
    }

    public function delete_menu($data) {
        if (!($stmt = $this->conn->prepare("DELETE FROM menu WHERE menu_id = ?"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->bind_param("s",
            $data['id']
        )) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" .  $this->conn->error;
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $this->conn->close();
    }

    public function get_menu() {
        $sql = "SELECT * from menu";
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $menu = new stdClass();
                $menu->id = $row["menu_id"];
                $menu->name_th = $row["menu_name_th"];
                $menu->name_en = $row["menu_name_en"];
                $menu->url = $row["menu_url"];
                array_push($data, $menu);
            }
        } else {
            return array();
        }

        $this->conn->close();
        return $data;
    }

    public function get_category() {
        $sql = "SELECT * from category";
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $category = new stdClass();
                $category->id = $row["category_id"];
                $category->name = $row["category_name"];
                array_push($data, $category);
            }
        } else {
            return array();
        }

        $this->conn->close();
        return $data;
    }

    public function create_category($data) {
        if (!($stmt = $this->conn->prepare("INSERT INTO category (category_id, category_name) VALUES (?, ?)"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->bind_param("ss",
            $data['id'],
            $data['name']
        )) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" .  $this->conn->error;
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $this->conn->close();
    }

    public function update_category($data) {
        if (!($stmt = $this->conn->prepare("UPDATE category SET category_name = ? WHERE category_id = ?"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->bind_param("ss",
            $data['name'],
            $data['id']
        )) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" .  $this->conn->error;
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        // delete all category shop
        if (!($stmt = $this->conn->prepare("DELETE FROM shop_category WHERE category_id = ?"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->bind_param("s",
            $data['id']
        )) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" .  $this->conn->error;
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        foreach($data['shop_category'] as $d) {
            if (!($stmt = $this->conn->prepare("INSERT INTO shop_category (shop_category_id, shop_id, category_id) VALUES (?, ?, ?)"))) {
                     echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
            }
            if (!$stmt->bind_param("sss",
                $d['id'],
                $d['shop_id'],
                $d['category_id']
            )) {
                header("HTTP/1.1 500 Internal Server Error");
                echo "Error: " . $sql . "<br>" .  $this->conn->error;
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                header("HTTP/1.1 500 Internal Server Error");
                echo "Error: " . $sql . "<br>" . $con->error;
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
        }

        $this->conn->close();
    }

    public function delete_category($data) {
        if (!($stmt = $this->conn->prepare("DELETE FROM category WHERE category_id = ?"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->bind_param("s",
            $data['id']
        )) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" .  $this->conn->error;
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $this->conn->close();
    }

    public function create_shop($data) {
        if (!($stmt = $this->conn->prepare("INSERT INTO shop (shop_id, shop_detail) VALUES (?, ?)"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->bind_param("ss",
            $data['id'],
            $data['detail']
        )) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" .  $this->conn->error;
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $this->conn->close();
    }

    public function get_shop_by_id($id) {
        $sql = "SELECT * from shop where shop_id = '".$id."'";
        $result = $this->conn->query($sql);
        $shop = new stdClass();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $shop->id = $row["shop_id"];
                $shop->detail = $row["shop_detail"];
            }
        } else {
            return null;
        }

        $this->conn->close();
        return $shop;
    }

    public function get_shop() {
        $sql = "SELECT * from shop";
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $shop = new stdClass();
                $shop->id = $row["shop_id"];
                $shop->detail = $row["shop_detail"];
                array_push($data, $shop);
            }
        } else {
            return array();
        }

        $this->conn->close();
        return $data;
    }

    public function update_shop($data) {
        if (!($stmt = $this->conn->prepare("UPDATE shop SET shop_detail = ? WHERE shop_id = ?"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->bind_param("ss",
            $data['detail'],
            $data['id']
        )) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" .  $this->conn->error;
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $this->conn->close();
    }

    public function get_shop_category($id) {
        $sql = "SELECT * from shop_category where category_id = '".$id. "'";
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $shop_category = new stdClass();
                $shop_category->id = $row["shop_category_id"];
                $shop_category->shop_id = $row["shop_id"];
                $shop_category->category_id = $row["category_id"];
                array_push($data, $shop_category);
            }
        } else {
            return array();
        }

        $this->conn->close();
        return $data;
    }

    public function get_top_shop() {
        $sql = "SELECT * from top_shop";
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $top_shop = new stdClass();
                $top_shop->id = $row["shop_id"];
                array_push($data, $top_shop);
            }
        } else {
            return array();
        }

        $this->conn->close();
        return $data;
    }

    public function update_top_shop($data) {
        // delete all top shop
        if (!($stmt = $this->conn->prepare("DELETE FROM top_shop WHERE shop_id != '?'"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        foreach($data['top_shop'] as $d) {
            if (!($stmt = $this->conn->prepare("INSERT INTO top_shop (shop_id) VALUES (?)"))) {
                     echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
            }
            if (!$stmt->bind_param("s",
                $d['id']
            )) {
                header("HTTP/1.1 500 Internal Server Error");
                echo "Error: " . $sql . "<br>" .  $this->conn->error;
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                header("HTTP/1.1 500 Internal Server Error");
                echo "Error: " . $sql . "<br>" . $con->error;
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
        }

        $this->conn->close();
    }

    public function get_shop_menu($id) {
        $sql = "SELECT * from shop_menu where shop_id = '".$id."'";
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($data, $row["menu_id"]);
            }
        } else {
            return array();
        }

        $this->conn->close();
        return $data;
    }

    public function update_shop_menu($data) {
        // delete all top shop
        if (!($stmt = $this->conn->prepare("DELETE FROM shop_menu WHERE shop_id = ?"))) {
                 echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
        }
        if (!$stmt->bind_param("s",
            $data['shop_id']
        )) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" .  $this->conn->error;
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        if (!$stmt->execute()) {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . $sql . "<br>" . $con->error;
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        foreach($data['menu_id'] as $id) {
            if (!($stmt = $this->conn->prepare("INSERT INTO shop_menu (shop_id, menu_id) VALUES (?, ?)"))) {
                     echo "Prepare failed: (" .  $this->conn->errno . ") " .  $this->conn->error;
            }
            if (!$stmt->bind_param("ss",
                $data['shop_id'],
                $id
            )) {
                header("HTTP/1.1 500 Internal Server Error");
                echo "Error: " . $sql . "<br>" .  $this->conn->error;
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                header("HTTP/1.1 500 Internal Server Error");
                echo "Error: " . $sql . "<br>" . $con->error;
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
        }

        $this->conn->close();
    }

    public function get_search($param) {
        if($_GET['search_by'] == "category") {
            $sql = "SELECT * FROM shop_category sc JOIN shop s ON sc.shop_id = s.shop_id WHERE sc.category_id = '".$_GET['id']."'";
            $result = $this->conn->query($sql);
            $data = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $shop = new stdClass();
                    $shop->id = $row["shop_id"];
                    $shop->detail = $row["shop_detail"];
                    array_push($data, $shop);
                }
            } else {
                return array();
            }

            $this->conn->close();
            return $data;
        }
        if($_GET['search_by'] == "type") {
            $sql = "SELECT * FROM shop_menu sm JOIN shop s ON sm.shop_id = s.shop_id WHERE sm.menu_id = '".$_GET['id']."'";
            $result = $this->conn->query($sql);
            $data = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $shop = new stdClass();
                    $shop->id = $row["shop_id"];
                    $shop->detail = $row["shop_detail"];
                    array_push($data, $shop);
                }
            } else {
                return array();
            }

            $this->conn->close();
            return $data;
        }
        if($_GET['search_by'] == "word") {
            $sql = "SELECT * FROM `shop` WHERE shop_detail LIKE '%".$_GET['query']."%'";
            $result = $this->conn->query($sql);
            $data = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $shop = new stdClass();
                    $shop->id = $row["shop_id"];
                    $shop->detail = $row["shop_detail"];
                    array_push($data, $shop);
                }
            } else {
                return array();
            }

            $this->conn->close();
            return $data;
        }
    }
}
