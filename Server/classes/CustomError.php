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
    public static function errorUnknown(): array
    {
        return [
            'error_message' => 'Unknown Error',
            'error_code' => 0
        ];
    }
    public static function errorUsername($username): array
    {
        return [
            'error_message' => "$username уже зарегистрирован",
            'error_code' => 4
        ];
    }
    public static function errorEmail(): array
    {
        return [
            'error_message' => "Данная почта уже использовалась",
            'error_code' => 5
        ];
    }

    public static function errorAuthorization(): array
    {
        return [
            'error_message' => 'Неверно имя пользователя или пароль',
            'error_code' => 6
        ];
    }
    public static function errorExit(): array
    {
        return [
            'error_message' => 'Пользователь не в системе',
            'error_code' => 7
        ];
    }
    public static function errorValidation($data): null|array
    {
        $err = CustomError::validateByRegistration($data);
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
            ->add('password', 'required | MinLength(5)',null, null, 'password');
        $validator->validate($data);
        $errors = [];
        foreach ($validator->getMessages() as $el) {
            foreach ($el as $value) {
                $errors[] = $value->getTemplate();
            }
        }
        return $errors;
    }
    public static function errorAdmin(): array
    {
        return [
            'error_message' => 'Недостаточно прав для выполнение этого',
            'error_code' => 'admin'
        ];
    }
}