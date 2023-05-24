<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Class Errors
 * @package EricksonReyes\RestApiResponse
 */
class Errors extends Collection implements ErrorsInterface
{

    /**
     * @param \EricksonReyes\RestApiResponse\ErrorInterface $error
     * @return void
     */
    public function addError(ErrorInterface $error): void
    {
        $this->addItem($error);
    }

    /**
     * @return array|\EricksonReyes\RestApiResponse\ErrorsInterface[]
     */
    public function errors(): array
    {
        return $this->items();
    }
}
