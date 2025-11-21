<?php
function add(float $x, float $y): float
{
    return $x + $y;
}

function sub(float $x, float $y): float
{
    return $x - $y;
}

function mul(float $x, float $y): float
{
    return $x * $y;
}

function div(float $x, float $y): float|string
{
    return $y !== 0.0 ? $x / $y : 'Error divide by 0';
}

function calculate(float $x, float $y, string $operation): float|string
{
    return match ($operation) {
        'add' => add($x, $y),
        'sub' => sub($x, $y),
        'mul' => mul($x, $y),
        'div' => div($x, $y),
        default => 'Error operation',
    };
}


















function calc(float $x, float $y, string $operation): float|string
{
    if (function_exists($operation)) {
        return $operation($x, $y);
    }
        return "Error operation";
}