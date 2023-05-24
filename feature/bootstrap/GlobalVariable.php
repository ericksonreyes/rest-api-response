<?php

/**
 * Class GlobalVariable
 */
class GlobalVariable
{

    /**
     * @var \GlobalVariable|null
     */
    private static ?GlobalVariable $instance = null;

    /**
     * @var string[]
     */
    private array $storedPayload = [];

    /**
     * This is a singleton, should not be instantiated.
     */
    private function __construct()
    {
    }

    /**
     * @return \GlobalVariable
     */
    public static function getInstance(): GlobalVariable
    {
        if (self::$instance == null) {
            self::$instance = new GlobalVariable();
        }

        return self::$instance;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function set(string $key, string $value): void
    {
        $this->storedPayload[$key] = $value;
    }

    /**
     * @param string $key
     * @return string
     */
    public function get(string $key): string
    {
        return $this->storedPayload[$key] ?? '';
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return !empty($this->storedPayload[$key]);
    }
}
