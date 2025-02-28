<?php

declare(strict_types=1);

class DB {

    private
        $pdo,
        $query,
        $error = false,
        $results,
        $count = 0;

    public function __construct(string $dbHost, string $dbName) {
        try {
            Config::initEnv();
            $dsn = 'mysql:host=' . $dbHost . ';dbname=' . $dbName .'';
            $this->pdo = new PDO($dsn, getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Failed to connect to Database: " . $e->getMessage();
            exit;
        }
    }

    public function query(string $sql, array $params = []): self
    {
        if (!empty($params)) {
            $this->error = false;
            if ($this->query = $this->pdo->prepare($sql)) {
                $x = 1;
                if (count($params)) {
                    if (is_array($params) || is_object($params) || is_string($params) || is_numeric($params)) {
                        foreach ($params as $param) {
                            $this->query->bindValue($x, $param);
                            $x++;
                        }
                    }
                }

                if ($this->query->execute()) {
                    $this->results = $this->query->fetchAll(PDO::FETCH_ASSOC);
                    $this->count = count($this->results);
                } else {
                    $this->error = true;
                }
            }
            return $this;
        } else {
            $this->error = false;
            if ($this->query = $this->pdo->prepare($sql)) {
                if ($this->query->execute()) {
                    $this->results = $this->query->fetchAll(PDO::FETCH_ASSOC);
                    $this->count = count($this->results);
                } else {
                    $this->error = true;
                }
            }
            return $this;
        }
    }

    public function getExecute()
    {
        return $this->query->execute();
    }

    public function fetch()
    {
        return $this->query->fetch(PDO::FETCH_ASSOC);
    }

    public function quantityRows()
    {
        return $this->count;
    }

    public function results()
    {
        return $this->results;
    }

    public function first()
    {
        return $this->results[0] ?? '';
    }

    public function last()
    {
        return $this->results[$this->count - 1];
    }

    public function error()
    {
        return $this->error;
    }
}

