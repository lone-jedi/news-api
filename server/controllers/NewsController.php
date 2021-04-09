<?php

class NewsController
{
    private string $type;
    private array $args;
    private News $news;
    private DbModel $dbconnection;
    
    public function __construct(DbModel $dbconnection, string $type, array $args)
    {
        $this->args = $args;
        $this->type = $type;
        $this->dbconnection = $dbconnection;
        $this->news = new News($this->dbconnection);
    }

    public function get()
    {
        if($this->type === 'all') {
            return  $this->news->all();
        } else if($this->type === 'one') {
            if(isset($this->args[1]) && is_numeric($this->args[1])) {
                return  $this->news->one($this->args[1]);
            } else {
                throw new HttpException('Incorrect argument "id"', 404);
            }
        }
    }

    public function post() 
    {
        if($this->type === 'add') {
            if(isset($_POST['title']) && isset($_POST['content'])) {
                return  $this->news->add($_POST['title'], $_POST['content']); 
            } else {
                throw new HttpException('Arguments "title" or "content" for add not found', 404);
            }
        }
    }

    public function put() 
    {
        if($this->type === 'update') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            if(isset($data['id']) && isset($data['title']) && isset($data['content'])) {
                return $this->news->update($data['id'], $data['title'], $data['content']); 
            } else {
                throw new HttpException('Arguments "id" or "title" or "content" for update not found', 404);
            }
        }
    }

    public function delete() 
    {
        if($this->type === 'delete') {
            if(isset($this->args[1]) && is_numeric($this->args[1])) {
                return $this->news->delete($this->args[1]); 
            } else {
                throw new HttpException('Arguments "id" for delete not found', 404);
            }
        }
    }
}