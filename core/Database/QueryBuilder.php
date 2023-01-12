<?php

namespace Core\Database;

use PDO;

class QueryBuilder
{
    private array $whereStack;

    private array $arrayOfWhereStrings;

    private array $arrayOfBindingValues;

    private string $table;

    public function __construct(private readonly PDO $pdo)
    {}

    public function setTable(string $table): static
    {
        $this->table = $table;
        return $this;
    }

    public function first()
    {
        $this->buildWheres();

        $conditionFullString = '';

        if(count($this->arrayOfWhereStrings)) {
            $conditionFullString = ' WHERE '. implode(' AND ', $this->arrayOfWhereStrings);
        }

        $conditionFullString .= ' LIMIT 1';

        return $this->select('*', $this->table, $conditionFullString);
    }

    private function buildWheres(): void
    {
        array_reduce($this->whereStack, function ($accumulator, $where) {
            $this->arrayOfWhereStrings[] = $this->buildSingleWhere($where);
            $this->arrayOfBindingValues[] = $where['value'];
        });
    }

    private function buildSingleWhere($where): string
    {
        return "{$where['fieldName']}{$where['operator']}?";
    }

    public function select(string $columns, string $table, string $conditions = '')
    {
        $query = "SELECT {$columns} FROM `{$table}`";

        if(! empty($conditions)) {
            $query .= $conditions;
        }

        $statement = $this->prepare($query);
        return $this->execute($statement, 'fetch');
    }

    public function where(string $fieldName, string $operator, string $value)
    {
        $this->whereStack[] = compact('fieldName', 'operator', 'value');

        return $this;
    }

    private function prepare(string $query)
    {
        return $this->pdo->prepare($query);
    }

    private function execute($statement, $fetch)
    {
        try {
            $statement->execute($this->arrayOfBindingValues);
            return $statement->{$fetch}();
        }catch (\Exception $e) {
            dd($e);
        }
    }
}