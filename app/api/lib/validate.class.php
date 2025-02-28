<?php

declare(strict_types=1);

class Validate {

    const LENGTH_VALIDATE_TYPE = 'length';
    const PHONE_VALIDATE_TYPE = 'phone_format';
    const EMAIL_VALIDATE_TYPE = 'email_format';
    const MIN_LENGTH = 3;
    const MAX_LENGHT = 100;
    private $data = [];
    private $errors = [];
    private $isError;

    public function escape(mixed $data)
    {
        return htmlentities($data, ENT_QUOTES);
    }

    public function notEmpty($data, $fieldName): string|bool
    {
        if (strlen($data) < 1) {
            $this->errors = "field $fieldName cannot be empty.";
        } else {
            return true;
        }
        return $this->errors;
    }

    public function minLength($data, $param, $fieldName): string|bool
    {
        if (strlen($data) < $param) {
            $this->errors = "the entered value for the $fieldName field should contain at least $param characters.";
        } else {
            return true;
        }
        return $this->errors;
    }

    public function maxLength($data, $param, $fieldName): string|bool
    {
        if (strlen($data) > $param) {
            $this->errors = "the entered value of the $fieldName field should not exceed $param characters.";
        } else {
            return true;
        }
        return $this->errors;
    }

    public function email($data): string|bool
    {
        if (!filter_var($data, FILTER_VALIDATE_EMAIL) && isset($data))
        {
            $this->errors = "invalid email address format.";
        } else {
            return true;
        }

        return $this->errors;
    }

    public function phone($data): string|bool
    {
        $pattern = '/^\d{9}$/';
        if (!preg_match($pattern, $data)) {
            $this->errors = "invalid phone number format.";
        } else {
            return true;
        }
        return $this->errors;
    }

    public function run($data, $fields = null, $type = null)
    {
        switch ($type) {
            case 'length':
                foreach ($fields as $field) {
                    $this->data['not_empty'] = $this->notEmpty($data, $field);
                    $this->data['min_length'] = $this->minLength($data, self::MIN_LENGTH, $field);
                    $this->data['max_length'] = $this->maxLength($data, self::MAX_LENGHT, $field);
                }

                $res = array_filter($this->data, function($k) {
                    if (isset($k) && $k !== 'email_format' && $k !== 'phone_format'){
                        return $this->data;
                    }
                }, ARRAY_FILTER_USE_KEY);

                return $res;
            case 'phone_format':
                $this->data[self::PHONE_VALIDATE_TYPE] = $this->phone($data);

                $res = array_filter($this->data, function($k) {
                    if (isset($k) && $k === 'phone_format'){
                        return $this->data;
                    }
                }, ARRAY_FILTER_USE_KEY);

                return $res;
            case 'email_format':
                $this->data[self::EMAIL_VALIDATE_TYPE] = $this->email($data);

                $res = array_filter($this->data, function($k) {
                    if (isset($k) && $k === 'email_format'){
                        return $this->data;
                    }
                }, ARRAY_FILTER_USE_KEY);

                return $res;
        }
    }

    public function checkErrors(array $errors, array $fields = []): array|bool
    {
        $this->isError = false;
        foreach ($fields as $field) {
            foreach ($errors['errors'][$field] as $check) {
                if (is_string($check)) {
                    $this->isError[] = true;
                }
            }
        }
        if (!empty($this->isError)) {
            echo 'validate error:';
        }

        return $this->isError;
    }
}