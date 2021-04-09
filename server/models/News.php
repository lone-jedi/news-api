<?php

class News
{
    private DbModel $dbconnection;

    function __construct(DbModel $dbconnection) 
    {
        $this->dbconnection = $dbconnection;
    }

    public function all() : array
    {
        $sql = "SELECT * FROM `news`";
        return $this->dbconnection->dbQuery($sql)->fetchAll();
    }

    public function one(int $id) : array
    {
        $sql = "SELECT * FROM `news` WHERE `id`=:id";
        $result = $this->dbconnection->dbQuery($sql, ["id" => $id])->fetch();
        if(!$result) {
            throw new HttpException("Error! No news with id $id", 404);
        }
        return $result;
    }

    public function add(string $title, string $content) : int
    {
        $sql = "INSERT INTO `news`(`title`, `content`) VALUES (:title, :content)";
        $this->dbconnection->dbQuery($sql, [
            "title"   => $title,
            "content" => $content
            ]);
        return $this->dbconnection->getConnection()->lastInsertId();
    }

    public function update(int $id, string $title, string $content) : bool
    {
        $sql  = "UPDATE `news` SET `title`=:title,`content`=:content WHERE `id`=:id";
        $rows = $this->dbconnection->dbQuery($sql, [
            "id"      => $id,
            "title"   => $title,
            "content" => $content
            ])->rowCount();
        return $rows !== 0;
    }

    public function delete(int $id) : bool
    {
        $sql  = "DELETE FROM `news` WHERE `id`=:id";
        $rows = $this->dbconnection->dbQuery($sql, ["id" => $id])->rowCount();
        return $rows !== 0;
    }
}