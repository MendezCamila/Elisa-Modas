<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCuit implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Eliminar cualquier carácter no numérico
        $cuit = preg_replace('/[^\d]/', '', $value);

        // Verificar que el CUIT tenga 11 dígitos
        if (strlen($cuit) != 11) {
            $fail('El CUIT debe tener 11 dígitos.');
            return;
        }

        // Algoritmo de validación del CUIT
        $acumulado = 0;
        $digitos = str_split($cuit);
        $digito_verificador = (int) array_pop($digitos);
        $multiplicadores = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

        foreach ($digitos as $i => $digito) {
            $acumulado += $digito * $multiplicadores[$i];
        }

        $resultado = 11 - ($acumulado % 11);
        if ($resultado == 11) $resultado = 0;
        if ($resultado == 10) $resultado = 9;

        // Comprobar si el resultado coincide con el dígito verificador
        if ($resultado !== $digito_verificador) {
            $fail('El CUIT ingresado no es válido.');
        }
    }
}
