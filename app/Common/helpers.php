<?php

function env(string $envKey): ?string
{
    return $_ENV[$envKey] ?? null;
}