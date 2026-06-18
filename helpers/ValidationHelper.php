<?php

function validatePostRequest(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método inválido.'
        );
    }
}

function validatePositiveId(
    int $id
): void
{
    if ($id <= 0) {

        throw new Exception(
            'ID inválido.'
        );
    }
}

function validateAllowedValue(
    string $value,
    array $allowed,
    string $message
): void
{
    if (
        !in_array(
            $value,
            $allowed
        )
    ) {

        throw new Exception(
            $message
        );
    }
}