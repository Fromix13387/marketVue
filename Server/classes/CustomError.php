<?php

use Sirius\Validation\Validator;

class CustomError
{
    public static function errorPasswordConfirm(): array
    {
        return [
            'error_message' => 'Пароли не совпадают!',
            'error_code' => 4
        ];
    }
    public static function errorMethodNotFound(): array
    {
        return [
            'error_message' => 'Method not found',
            'error_code' => 1
        ];
    }
    public static function errorUnknown()
    {
        return [
            'error_message' => 'Unknown Error',
            'error_code' => 0
        ];
    }
    public static function errorValidation($data): null|array
    {
        $err = CustomError::validateByRegistration($_POST);
        return count($err) !== 0 ? [
            'error_message' => $err[0],
            'error_code' => 3
        ] : null;
    }
    public static function validateByRegistration($data): array
    {
        $validator = new Validator;
        $validator
            ->add('username', 'required', null )
            ->add('fullname', 'required | fullName', null)
            ->add('email', 'required | email', null)
            ->add('password', 'required | MinLength(5)',null);
        $validator->validate($data);
        $errors = [];
        foreach ($validator->getMessages() as $el) {
            foreach ($el as $value) {
                $errors[] = $value->getTemplate();
            }
        }
        return $errors;
    }
}