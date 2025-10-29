<?php

abstract class Operaciones
{
    public function __construct(public int $x, public int $y) {}

    abstract public function sumar(): int;

    abstract public function restar(): int;
}

class Calculadora extends Operaciones
{
    public function sumar(): int
    {
        $resultado = $this->x + $this->y;

        return $resultado;
    }

    public function restar(): int
    {
        $resultado = $this->x - $this->y;

        return $resultado;
    }
}

$calculadora = new Calculadora(5, 4);

echo $calculadora->sumar();
echo '<br>';
echo $calculadora->restar();