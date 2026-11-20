<?php

namespace App\Libraries;

use App\Enums\ErrorCodeEnum;
use App\Http\Exceptions\CustomHttpException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ExceptionLib
{
    protected $request = null;
    protected array $messages = [];
    protected array $attributes = [];
    protected string $errorCode = ErrorCodeEnum::VALIDATION_FAILED->value;

    public function __construct(protected array $rules = [])
    {
        
    }

    public static function throwCustomException(string $message, string $errorCode, ?string $failedAttribute = null)
    {
        throw new CustomHttpException($message, $errorCode, $failedAttribute);
    }

    public function setRequest($request): static
    {
        $this->request = $request;

        return $this;
    }

    public function messages(array $messages): static
    {
        $this->messages = $messages;

        return $this;
    }

    public function attributes(array $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function errorCode(string $errorCode): static
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    public static function make(array $rules)
    {
        return new static($rules);
    }

    public function validate()
    {
        $req = $this->request ?: request();
        $data = is_array($req) ? $req : $req->all();

        // 1. Process rules to ensure 'bail' is at the start
        $bailedRules = collect($this->rules)->map(function ($rule) {
              // 1. Normalize: Convert "required|string" to ["required", "string"]
            $ruleArray = is_string($rule) ? explode('|', $rule) : (array) $rule;

            // 2. Strict Filter: Remove 'bail' if it exists (avoids Object-to-String conversion errors)
            // This is safe for Rule Objects like new Password() or custom closures
            $ruleArray = array_filter($ruleArray, function ($value) {
                return $value !== 'bail';
            });

            // 3. Prepend: Always put 'bail' at index 0
            array_unshift($ruleArray, 'bail');

            return array_values($ruleArray);
        })->toArray();

        // 2. Create Validator
        $validator = Validator::make($data, $bailedRules, $this->messages, $this->attributes);
        // $validator->stopOnFirstFailure();

        // try {
            return $validator->validate();
        // } catch (ValidationException $e) {
        //     $errors = $e->validator->errors();
        //     $failedAttribute = array_key_first($errors->getMessages()); 

        //     self::throwCustomException(
        //         $errors->first(),
        //         $this->errorCode,
        //         $failedAttribute
        //     );
        // }
    }
}
