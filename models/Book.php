<?php

namespace app\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
{

    public $authorIds;

    
    public static function tableName()
    {
        return '{{%book}}';
    }

    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->via('bookAuthors');
    }

    public function rules()
    {
        return [
            [['title', 'year', 'isbn'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title', 'isbn', 'cover_url'], 'string', 'max' => 255],
            [['isbn'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'cover_url' => 'Обложка (URL)',
        ];
    }
}