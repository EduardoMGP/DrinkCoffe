<?php

namespace App\Controllers;

class Controller
{

    public function validate($data, $validator)
    {
        $errors = [];
        $validate = $validator::validate($data);
        foreach ($validate as $key => $value) {

            if (isset($data[$key]) && $data[$key] != "") {

                if (isset($value['min'])) {
                    if (strlen($data[$key]) < $value['min']) {
                        $errors[$key][] = str_replace("{min}", $value['min'], $value['error']['min']
                            ?? "The field {$key} must be at least {min} characters");
                    }
                }

                if (isset($value['max'])) {
                    if (strlen($data[$key]) > $value['max']) {
                        $errors[$key][] = str_replace("{max}", $value['max'], $value['error']['max']
                            ?? "The field {$key} must be at most {max} characters");
                    }
                }

                if (isset($value['regex'])) {
                    if (!preg_match($value['regex'], $data[$key])) {
                        $errors[$key][] = $value['error']['regex'] ?? "The field {$key} is invalid";
                    }
                }

            } else if (isset($value['required']) && $value['required'] === true) {
                $errors[$key][] = $value['error']['required'] ?? "The field {$key} is required";
            }

        }

        if (count($errors) > 0) {
            return $errors;
        }

        return true;
    }
}