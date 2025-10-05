<?php

namespace app\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%author}}';
    }

    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->via('bookAuthors');
    }

    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::class, ['author_id' => 'id']);
    }

    public function rules()
    {
        return [
            [['full_name'], 'required'],
            [['full_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО автора',
        ];
    }
}