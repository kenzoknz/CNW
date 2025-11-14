<?php
/**
 * Validation Service
 */

namespace Service;

class ValidationService
{
    private $errors = [];

    /**
     * Validate required field
     */
    public function required($value, $fieldName)
    {
        if (empty($value)) {
            $this->errors[$fieldName] = "$fieldName không được để trống";
            return false;
        }
        return true;
    }

    /**
     * Validate length
     */
    public function length($value, $fieldName, $min, $max)
    {
        $len = strlen($value);
        if ($len < $min || $len > $max) {
            $this->errors[$fieldName] = "$fieldName phải từ $min đến $max ký tự";
            return false;
        }
        return true;
    }

    /**
     * Validate numeric
     */
    public function numeric($value, $fieldName)
    {
        if (!is_numeric($value)) {
            $this->errors[$fieldName] = "$fieldName phải là số";
            return false;
        }
        return true;
    }

    /**
     * Validate email
     */
    public function email($value, $fieldName)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$fieldName] = "$fieldName không hợp lệ";
            return false;
        }
        return true;
    }

    /**
     * Get errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Check if has errors
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * Clear errors
     */
    public function clear()
    {
        $this->errors = [];
    }
}
