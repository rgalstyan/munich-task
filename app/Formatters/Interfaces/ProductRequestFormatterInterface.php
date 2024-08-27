<?php

declare(strict_types=1);

namespace App\Formatters\Interfaces;

interface ProductRequestFormatterInterface
{
    /**
     * @param array $request {
     *     user_id: ?int,
     *     category_id: ?int,
     *     min_price: ?float,
     *     max_price: ?float,
     *     search: ?string,
     *     page: int,
     *     per_page: int
     * }
     * @return self
     */
    public function __invoke(array $request): self;

    public function getUserId(): ?int;

    public function getCategoryId(): ?int;

    public function getMinPrice(): ?float;

    public function getMaxPrice(): ?float;

    public function getSearch(): ?string;

    public function getPage(): int;

    public function getPerPage(): int;
}
