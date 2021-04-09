<?php

class NewsController
{
    private News $news;
    private DbModel $dbconnection;
    
    public function __construct()
    {
        $this->dbconnection = new DbModel(DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $this->news = new News($this->dbconnection);
    }

    public function all() {
        return $this->news->all();
    }

    public function one(int $id) {
        return $this->news->one($id);
    }

    public function add() {
        if(!isset($_POST['title']) || !isset($_POST['content'])) {
            throw new HttpException('Arguments title or content not found', 404);
        } 
        return  $this->news->add($_POST['title'], $_POST['content']); 
    }

    public function update() {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);

        if(!isset($data['id']) || !isset($data['title']) || !isset($data['content'])) {
            throw new HttpException('Arguments id or title or content for update not found', 404);
        } 
        return $this->news->update($data['id'], $data['title'], $data['content']); 
    }

    public function delete($id) {
        return $this->news->delete($id);      
    }
}