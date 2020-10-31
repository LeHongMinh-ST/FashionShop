<?php
require_once 'Connection.php';

class Model
{
    protected $connection;
    protected $table;
    private $col;
    private $condition;

    function __construct()
    {
        $conn = new Connection();
        $this->connection = $conn->connect();
    }

    public function all()
    {
        $query = "SELECT * FROM $this->table ";

        $result = $this->connection->query($query);

        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    /*
    *Hàm chọn các trường thông tin
    *@params null
    *@return Object
    */
    public function select()
    {
        $string = '';
        $data = func_get_args();
        foreach ($data as $value) {
            $string .= $value . " ";
        }

        $this->col = $string;

        return $this;
    }

    /*
    *Hàm lấy các bản ghi
    *@params null
    *@return Array
    */
    public function get()
    {
        $col = ($this->col) ? $this->col : '*';
        $condition = ($this->condition) ? $this->condition : '1';
        $query = "SELECT $col FROM $this->table WHERE $condition ";

        $result = $this->connection->query($query);

        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    /*
    *Hàm thêm điều kiện cho truy vấn bản ghi
    *@params Array $data
    *@return Object
    */
    public function where($where)
    {
        $string = '';
        $i = 0;
        foreach ($where as $column => $value) {
            $string .= $column . " = " . "'" . $value . "'";
            $i++;

            if ($i != count($where)) {
                $string .= " AND ";
            }
        }

        $this->condition = $string;

        return $this;
    }

    /*
    *Hàm tìm kiếm có điều kiện đưa ra 1 bản ghi
    *@params array $data
    *@return array $data
    */
    public function first(array $where = [])
    {
        if ($where) {
            $string_1 = "";
            $i = 0;
            $query = "SELECT * FROM  $this->table WHERE ";
            foreach ($where as $column => $value) {
                $string_1 .= $column . " = " . "'" . $value . "'";
                $i++;

                if ($i != count($where)) {
                    $string_1 .= " AND ";
                }
            }

            $query = $query . $string_1;

            $result = $this->connection->query($query);
            return $result->fetch_assoc();
        }

        $col = ($this->col) ? $this->col : '*';
        $condition = ($this->condition) ? $this->condition : '1';
        $query = "SELECT $col FROM $this->table WHERE $condition ";

        $result = $this->connection->query($query);

        return $result->fetch_assoc();
    }

    public function find($id)
    {
        $query = "SELECT * FROM  $this->table WHERE id = $id";

        $result = $this->connection->query($query);
        return $result->fetch_assoc();
    }

    /*
    *Hàm tạo mới 1 bản ghi
    *@params array $data
    *@return boolen
    */
    public function create($data)
    {
        $string_1 = "";
        $string_2 = "";
        $i = 0;

        $query = "INSERT INTO $this->table ";

        foreach ($data as $column => $value) {
            $string_1 .= $column;
            $i++;

            if ($i != count($data)) {
                $string_1 .= ",";
            }

            $string_2 .= "'" . $value . "'";
            if ($i != count($data)) {
                $string_2 .= ",";
            }
        }

        $string = '(' . $string_1 . ')' . ' VALUES ' . '(' . $string_2 . ')';

        $query .= $string;

        $result = $this->connection->query($query);

        return $result;
    }

    /*
    *Hàm cập nhật 1 bản ghi
    *@params array $data
    *@return boolen
    */
    public function update($id, $data)
    {
        $string_1 = "";
        $i = 0;

        $query = "UPDATE  $this->table SET ";
        $query_1 = " where id = $id";

        foreach ($data as $column => $value) {
            $string_1 .= $column . " = " . "'" . $value . "'";
            $i++;

            if ($i == 0) {
                $value = $id;
            }
            if ($i != count($data)) {
                $string_1 .= " , ";
            }
        }

        $query = $query . $string_1 . $query_1;

        $status = $this->connection->query($query);
        return $status;
    }

    /*
    *Hàm xóa 1 bản ghi
    *@params array $data
    *@return boolen
    */
    public function delete($id)
    {
        $query = "DELETE FROM $this->table where id = " . $id;

        $result = $this->connection->query($query);

        return $result;
    }
}