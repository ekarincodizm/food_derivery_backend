<?php

class model_home extends Model
{
    public function get_data()
    {
        // Change your query
        $sql = "SELECT * from symptom";
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                array_push($data, $row["id"]);
            }
        } else {
            return null;
        }

        $this->conn->close();
        // Change to return your data
        return $data;
    }
}
