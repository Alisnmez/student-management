<?php

$config = include('config.php');
class Database
{
    private $connection;

    public function startConnection($config)
    {
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'];
        $user = $config['user'];
        $password = $config['password'];

        try {
            $this->connection = new PDO($dsn, $user, $password);
            return $this->connection;
        } catch (PDOException $e) {
            echo 'Bağlama başarısız: ' . $e->getMessage();
            return null;
        }
    }
    public function closeConnection()
    {
        $this->connection = null;
    }
    public function save($table, $data = [])
    {
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $sth = $this->connection->prepare($sql);
        return $sth->execute(array_values($data));
    }
         
    public function getDatas($table, $columns = [], $conditions = [], $values = [])
    {
        if (empty($columns)) {
            $columnsList = '*';
        } else {
            $columnsList = implode(', ', $columns);
        }

        $sql = "SELECT $columnsList FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $query = $this->connection->prepare($sql);
        $query->execute($values);
        return $query;
    }

    public function updateDatas($table, $no, $data = [])
    {
        try {
            $columns = array_keys($data);
            $setClause = implode(' = ?, ', $columns) . ' = ?';
            $sql = "UPDATE $table SET $setClause WHERE `no` = ?";

            $sth = $this->connection->prepare($sql);
            //merge ile dizi birleştirildi        
            $result = $sth->execute(array_merge(array_values($data), [$no]));
            return $result;
        } catch (PDOException $e) {
            echo 'Hata: ' . $e->getMessage();
            return false;
        }
    }

    public function deleteDatas($table, $no)
    {
        $sql = "DELETE FROM $table WHERE `$table`.`no`=?";
        $sth = $this->connection->prepare($sql);
        $sth->execute([$no]);
    }
}
