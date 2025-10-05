<?php

namespace app\models;

use yii\db\ActiveRecord;

class BookAuthor extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%book_author}}';
    }

    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public function rules()
    {
        return [
            [['book_id', 'author_id'], 'required'],
            [['book_id', 'author_id'], 'integer'],
            [['book_id', 'author_id'], 'unique', 'targetAttribute' => ['book_id', 'author_id']],
        ];
    }
}