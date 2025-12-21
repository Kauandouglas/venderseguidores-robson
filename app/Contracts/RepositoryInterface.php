<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    /**
     * Retorna todos os registros
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Retorna registros paginados
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    /**
     * Encontra um registro por ID
     */
    public function find(int $id, array $columns = ['*']): ?Model;

    /**
     * Encontra um registro por ID ou lança exceção
     */
    public function findOrFail(int $id, array $columns = ['*']): Model;

    /**
     * Encontra um registro por campo
     */
    public function findBy(string $field, $value, array $columns = ['*']): ?Model;

    /**
     * Cria um novo registro
     */
    public function create(array $data): Model;

    /**
     * Atualiza um registro
     */
    public function update(int $id, array $data): bool;

    /**
     * Deleta um registro
     */
    public function delete(int $id): bool;

    /**
     * Carrega relacionamentos
     */
    public function with(array $relations): self;

    /**
     * Adiciona condição where
     */
    public function where(string $column, $operator = null, $value = null): self;

    /**
     * Adiciona condição whereIn
     */
    public function whereIn(string $column, array $values): self;

    /**
     * Ordena os resultados
     */
    public function orderBy(string $column, string $direction = 'asc'): self;

    /**
     * Limita os resultados
     */
    public function limit(int $limit): self;
}
