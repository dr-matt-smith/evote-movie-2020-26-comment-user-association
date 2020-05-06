<?php


namespace Tudublin;


class Comment
{
    const CREATE_TABLE_SQL =
        <<<HERE
    CREATE TABLE IF NOT EXISTS comment (
        id integer PRIMARY KEY AUTO_INCREMENT,
        comment text,
        userId integer
    )
    HERE;

    private $id;
    private $comment;
    private $userId;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUser()
    {
        // if not NULL userUId, then find and return associated user
        if(!empty($this->userId)){
            $userRepository = new UserRepository();
            return $userRepository->find($this->userId);
        }

        // if userId NULL, then return NULL
        return null;
    }

}