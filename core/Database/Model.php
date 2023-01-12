<?php

namespace Core\Database;

use Core\App;
class Model
{
    protected string $table = '';

    public function __construct(protected readonly QueryBuilder $queryBuilder)
    {}

    public function findById($id)
    {
        return $this->queryBuilder
            ->setTable($this->getTableName())
            ->where('id', '=', $id)
            ->first();
    }

    public function select($columns = '*')
    {
        $conditions = [];
        $this->queryBuilder->select($columns, $this->getTableName(), $conditions);
    }

    public function getTableName(): string
    {
        return $this->table;
    }

    public static function query(): static
    {
        $app = App::instance();

        return new static($app->get(QueryBuilder::class));
    }
}