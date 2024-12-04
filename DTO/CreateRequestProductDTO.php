<?php

namespace DTO;

readonly class CreateRequestProductDTO
{
    public function __construct(
        public string $code,
        public string $name,
        public int $price,
        public string|null $colour
    )
    {
    }
}